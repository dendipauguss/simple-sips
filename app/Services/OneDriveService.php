<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class OneDriveService
{
    private function getAccessToken($userId)
    {
        $token = DB::table('ms_token')->where('user_id', $userId)->first();

        if (!$token) {
            throw new \Exception('OneDrive belum terhubung');
        }

        if (now()->lt($token->expires_at)) {
            return $token->access_token;
        }

        // refresh token
        $response = Http::asForm()->post(
            'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            [
                'client_id' => config('services.microsoft.client_id'),
                'client_secret' => config('services.microsoft.client_secret'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $token->refresh_token,
                'scope' => 'offline_access Files.ReadWrite',
            ]
        );

        $newToken = $response->json();

        DB::table('ms_token')->where('user_id', $userId)->update([
            'access_token' => $newToken['access_token'],
            'expires_at'   => now()->addSeconds($newToken['expires_in']),
        ]);

        return $newToken['access_token'];
    }

    public function upload($userId, $filePath, $fileName, $folder)
    {
        $accessToken = $this->getAccessToken($userId);

        $safeFileName = rawurlencode($fileName);
        $safeFolder   = trim($folder, '/');

        $url = "https://graph.microsoft.com/v1.0/me/drive/root:/{$safeFolder}/{$safeFileName}:/content";

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/octet-stream',
            ])
            ->put($url, file_get_contents($filePath));

        if (!$response->successful()) {
            throw new \Exception(
                'Upload ke OneDrive gagal: ' . $response->body()
            );
        }

        return json_decode($response->body(), true);
    }
}
