<?php

namespace App\Transport\Onedrive\Auth;

use App\Models\OnedriveState;
use App\Services\Onedrive\Constant\OnedrivePermissionsConstant;
use App\Services\Onedrive\Constant\OnedriveUrlConstant;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class RenewTokenClient
{
    public function __construct()
    {
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function renewAccessToken(OnedriveState $oneDriveState): void
    {
        if ($oneDriveState->refresh_token === null) {
            throw new Exception(
                'The refresh token is not set or no permission for'
                . ' \'offline_access\' was given to renew the token'
            );
        }

        $scopes = OnedrivePermissionsConstant::PERMISSIONS;
        $values = [
            'client_id' => config('onedrive.ONEDRIVE_CLIENT_ID'),
            'client_secret' => config('onedrive.ONEDRIVE_CLIENT_SECRET'),
            'grant_type' => 'refresh_token',
            'scope'  => implode(' ', $scopes),
            'refresh_token' => $oneDriveState->refresh_token,
        ];

        $response = Http::asForm()->post(
            OnedriveUrlConstant::TOKEN_URL,
            $values
        );

        $body = (string)$response->getBody();
        $data = json_decode($body);

        if ($data === null) {
            throw new Exception('json_decode() failed');
        }

        $oneDriveState->token = $data->access_token;
        $oneDriveState->token_obtained_time = time();
        $oneDriveState->refresh_token = $data->refresh_token;
        $oneDriveState->expires_in = $data->expires_in;
        $oneDriveState->save();
    }
}
