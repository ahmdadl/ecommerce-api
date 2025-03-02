<?php

namespace Modules\Users\Utils;

class UserUtils
{
    public static function generateToken(): string
    {
        return random_int(100000, 999999);
    }
}
