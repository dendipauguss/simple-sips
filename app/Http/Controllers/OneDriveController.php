<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Services\OneDriveService;
use Illuminate\Support\Str;

class OneDriveController extends Controller
{
    /* ===========================
     * 1. Redirect ke Microsoft
     * =========================== */
    public function redirect()
    {
        $query = http_build_query([
            'client_id'     => env('MS_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri'  => env('MS_REDIRECT_URI'),
            'response_mode' => 'query',
            'scope'         => 'openid profile offline_access https://graph.microsoft.com/Files.ReadWrite',
            'state'         => csrf_token(),
        ]);

        return redirect(
            "https://login.microsoftonline.com/" . env('MS_TENANT_ID') . "/oauth2/v2.0/authorize?$query"
        );
    }

    /* ===========================
     * 2. Callback OAuth
     * =========================== */
    public function callback(Request $request)
    {
        $response = Http::asForm()->post(
            "https://login.microsoftonline.com/" . env('MS_TENANT_ID') . "/oauth2/v2.0/token",
            [
                'client_id'     => env('MS_CLIENT_ID'),
                'client_secret' => env('MS_CLIENT_SECRET'),
                'grant_type'    => 'authorization_code',
                'code'          => $request->code,
                'redirect_uri'  => env('MS_REDIRECT_URI'),
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
        $path = '/SIPS/' . time() . '_' . $file->getClientOriginalName();

        $response = Http::withToken($accessToken)->put(
            "https://graph.microsoft.com/v1.0/me/drive/root:$path:/content",
            file_get_contents($file)
        );

        if (!$response->successful()) {
            return back()->withErrors($response->json());
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
            "https://login.microsoftonline.com/" . env('MS_TENANT_ID') . "/oauth2/v2.0/token",
            [
                'client_id'     => env('MS_CLIENT_ID'),
                'client_secret' => env('MS_CLIENT_SECRET'),
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
