<?php

namespace Modules\Users\Enums;

use Modules\Core\Traits\HasEnumHelpers;

enum UserGender: string
{
    use HasEnumHelpers;

    case MALE = 'male';
    case FEMALE = 'female';
}
