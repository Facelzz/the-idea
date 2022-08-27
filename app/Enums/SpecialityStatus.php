<?php

declare(strict_types=1);

namespace App\Enums;

enum SpecialityStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
}
