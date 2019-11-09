<?php

namespace App\Enums;


use BenSampo\Enum\Enum;

final class LoginStatusType extends Enum
{
    const ACTIVE = 1;
    const INACTIVE = 0;
}