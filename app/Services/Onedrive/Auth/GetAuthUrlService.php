<?php

namespace App\Services\Onedrive\Auth;

use App\Services\Onedrive\Constant\OnedrivePermissionsConstant;
use App\Transport\Onedrive\Auth\AuthClient;

class GetAuthUrlService {
    public function __construct(
        private AuthClient $authClient,
    )
    {
    }
    public function getAuthUrl(): string
    {
        return $this->authClient->getLogInUrl(OnedrivePermissionsConstant::PERMISSIONS, config('onedrive.ONEDRIVE_REDIRECT_URI'));
    }
}
