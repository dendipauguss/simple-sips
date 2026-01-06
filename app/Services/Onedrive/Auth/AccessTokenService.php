<?php

namespace App\Services\Onedrive\Auth;


use App\Models\OnedriveState;
use App\Services\Onedrive\Constant\AccessTokenStatusConstant;
use App\Services\Onedrive\State\GetOnedriveStateService;
use Exception;
use Illuminate\Http\Client\ConnectionException;

class AccessTokenService
{
    private OnedriveState $onedriveState;

    public function __construct(
        private readonly GetOnedriveStateService $getOnedriveStateService,
        private readonly RenewAccessTokenService $renewAccessTokenService,
    )
    {
        $this->onedriveState = $this->getOnedriveStateService->getOnedriveState();
    }

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function getAccessToken():string
    {
        if ($this->onedriveState->refresh_token === null) {
            throw new Exception('Missing Refresh Token');
        }
        if (
            $this->getAccessTokenStatus() === AccessTokenStatusConstant::EXPIRING ||
            $this->getAccessTokenStatus() === AccessTokenStatusConstant::EXPIRED
        ) {
            $this->renewAccessTokenService->renewAccessToken();
            // fetch the modal again from the db since access token is changed.
            $this->onedriveState->refresh();
        }
        return $this->onedriveState->token;
    }

    public function getRefreshToken(): ?string
    {
        return $this->onedriveState->refresh_token;
    }

    public function getAccessTokenStatus(): int
    {
        if ($this->onedriveState->token === null) {
            return AccessTokenStatusConstant::MISSING;
        }

        $remaining = $this->getTokenExpire();

        if ($remaining <= 0) {
            return AccessTokenStatusConstant::EXPIRED;
        }

        if ($remaining <= 60) {
            return AccessTokenStatusConstant::EXPIRING;
        }

        return AccessTokenStatusConstant::VALID;
    }

    /**
     * Gets the access token expiration delay in seconds.
     *
     */
    public function getTokenExpire()
    {
        return $this->onedriveState->token_obtained_time
            + $this->onedriveState->expires_in - time();
    }
}
