<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Services\OneDriveService;
use Illuminate\Support\Str;
use App\Models\Files;

class OneDriveController extends Controller
{

    public function index()
    {
        return view('welcome', [
            'files' => Files::all()
        ]);
    }
    /* ===========================
     * 1. Redirect ke Microsoft
     * =========================== */
    public function redirect()
    {
        $query = http_build_query([
            'client_id'     => env('ONEDRIVE_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri'  => env('ONEDRIVE_REDIRECT_URI'),
            'response_mode' => 'query',
            'scope'         => 'openid profile offline_access https://graph.microsoft.com/Files.ReadWrite',
            'state'         => csrf_token(),
        ]);

        return redirect(
            "https://login.microsoftonline.com/" . env('ONEDRIVE_TENANT_ID') . "/oauth2/v2.0/authorize?$query"
        );
    }

    /* ===========================
     * 2. Callback OAuth
     * =========================== */
    public function callback(Request $request)
    {
        $response = Http::asForm()->post(
            "https://login.microsoftonline.com/" . env('ONEDRIVE_TENANT_ID') . "/oauth2/v2.0/token",
            [
                'client_id'     => env('ONEDRIVE_CLIENT_ID'),
                'client_secret' => env('ONEDRIVE_CLIENT_SECRET'),
                'grant_type'    => 'authorization_code',
                'code'          => $request->code,
                'redirect_uri'  => env('ONEDRIVE_REDIRECT_URI'),
            ]
        );

        $token = $response->json();
        if (isset($token['error'])) {
            return redirect()->route('dashboard')->with(
                'error',
                'Gagal login Microsoft: ' . $token['error_description']
            );
        }

        DB::table('ms_token')->updateOrInsert(
            ['user_id' => auth()->id()],
            [
                'access_token'  => $token['access_token'],
                'refresh_token' => $token['refresh_token'],
                'expires_at'    => now()->addSeconds($token['expires_in']),
            ]
        );

        return redirect()->route('dashboard')->with('success', 'OneDrive berhasil terhubung');
    }

    /* ===========================
     * 3. Upload File
     * =========================== */
    public function upload(Request $request)
    {

        $request->validate([
            'dokumen' => 'required|file|max:10240'
        ]);

        $accessToken = $this->getAccessToken(auth()->id());

        $file = $request->file('dokumen');
        $path = '/SIOMES Files/' . time() . '_' . $file->getClientOriginalName();

        $response = Http::withToken($accessToken)
            ->withBody(
                file_get_contents($file),
                'application/octet-stream'
            )
            ->put("https://graph.microsoft.com/v1.0/me/drive/root:$path:/content");

        if (!$response->successful()) {
            $error = $response->json();

            return back()->withErrors([
                'onedrive' => $error['error']['message'] ?? 'Upload ke OneDrive gagal'
            ]);
        }

        return back()->with('success', 'Upload ke OneDrive berhasil');
    }

    /* ===========================
     * 4. Refresh Token Otomatis
     * =========================== */
    private function getAccessToken($userId)
    {
        $token = DB::table('ms_token')->where('user_id', $userId)->first();

        if (now()->lt($token->expires_at)) {
            return $token->access_token;
        }

        $response = Http::asForm()->post(
            "https://login.microsoftonline.com/" . env('ONEDRIVE_TENANT_ID') . "/oauth2/v2.0/token",
            [
                'client_id'     => env('ONEDRIVE_CLIENT_ID'),
                'client_secret' => env('ONEDRIVE_CLIENT_SECRET'),
                'grant_type'    => 'refresh_token',
                'refresh_token' => $token->refresh_token,
                'scope'         => 'https://graph.microsoft.com/.default',
            ]
        );

        $data = $response->json();

        DB::table('ms_token')->where('user_id', $userId)->update([
            'access_token' => $data['access_token'],
            'expires_at'   => now()->addSeconds($data['expires_in']),
        ]);

        return $data['access_token'];
    }
}
