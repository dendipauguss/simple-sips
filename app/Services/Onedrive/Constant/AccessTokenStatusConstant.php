<?php

namespace App\Services\Onedrive\Constant;
class AccessTokenStatusConstant
{
    /**
     * @var int
     *      Access token is missing.
     *
     */
    public const MISSING = 0;

    /**
     * @var int
     *      Access token is expiring soon (1 minute or less).
     *
     */
    public const EXPIRING = -1;

    /**
     * @var int
     *      Access token is expired.
     *
     */
    public const EXPIRED = -2;

    /**
     * @var int
     *      Access token is valid.
     */
    public const VALID = 1;
}
