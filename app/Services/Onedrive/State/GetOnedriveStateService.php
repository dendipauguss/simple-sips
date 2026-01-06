<?php

namespace App\Services\Onedrive\State;

use App\Models\OnedriveState;

class GetOnedriveStateService {
    public function __construct()
    {
    }
    public function getOnedriveState(): OnedriveState {
        $onedriveState = OnedriveState::latest()->first();
        if(empty($onedriveState)) {
            $onedriveState = new OnedriveState();
            $onedriveState->save();
        }
        return $onedriveState;
    }
}
