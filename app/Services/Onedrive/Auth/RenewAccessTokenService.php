<?php

namespace App\Services\Onedrive\Auth;

use App\Models\OnedriveState;
use App\Services\Onedrive\State\GetOnedriveStateService;
use App\Transport\Onedrive\Auth\RenewTokenClient;
use Illuminate\Http\Client\ConnectionException;

class RenewAccessTokenService {
    private OnedriveState $onedriveState;
    public function __construct(
        private GetOnedriveStateService $getOnedriveStateService,
        private RenewTokenClient $renewTokenClient,
    )
    {
        $this->onedriveState = $this->getOnedriveStateService->getOnedriveState();
    }

    /**
     * @throws ConnectionException
     */
    public function renewAccessToken(): void
    {
        $this->renewTokenClient->renewAccessToken($this->onedriveState);
    }
}
