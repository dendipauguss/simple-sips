<?php

namespace App\Services\Onedrive\Auth;

use App\Transport\Onedrive\Auth\AuthClient;
use Illuminate\Http\Client\ConnectionException;

class StoreAuthCredService {
    public function __construct(
        private AuthClient $authClient,
    )
    {
    }

    /**
     * @throws ConnectionException
     */
    public function getAndStoreAccessToken(string $code): void
    {
        $this->authClient->getAndStoreAccessToken($code);
    }
}
