<?php
namespace App\Transport\Onedrive\Auth;

use App\Services\Onedrive\Constant\OnedriveUrlConstant;
use App\Services\Onedrive\State\GetOnedriveStateService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class AuthClient {
    public function __construct(
        private GetOnedriveStateService $getOnedriveStateService,
    )
    {
    }
    public function getLogInUrl(array $scopes, string $redirectUri) : string {
        $values = [
            'client_id'     => config('onedrive.ONEDRIVE_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri'  => $redirectUri,
            'scope'         => implode(' ', $scopes),
            'response_mode' => 'query',
        ];

        $query = http_build_query($values, '', '&', PHP_QUERY_RFC3986);
        return OnedriveUrlConstant::AUTH_URL . "?$query";
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function getAndStoreAccessToken(string $code) : void {
        $values = [
            'client_id'     => config('onedrive.ONEDRIVE_CLIENT_ID'),
            'redirect_uri'  => config('onedrive.ONEDRIVE_REDIRECT_URI'),
            'client_secret' => config('onedrive.ONEDRIVE_CLIENT_SECRET'),
            'code'          => (string) $code,
            'grant_type'    => 'authorization_code',
        ];

        $response = Http::asForm()->post(
            OnedriveUrlConstant::TOKEN_URL,
            $values
        );

        $body = (string) $response->getBody();
        $data = json_decode($body);

        if ($data === null) {
            throw new Exception('json_decode() failed');
        }
        $oneDriveState = $this->getOnedriveStateService->getOnedriveState();
        $oneDriveState->token = $data->access_token;
        $oneDriveState->token_obtained_time = time();
        $oneDriveState->refresh_token = $data->refresh_token;
        $oneDriveState->expires_in = $data->expires_in;
        $oneDriveState->save();
    }
}
