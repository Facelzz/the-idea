<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * @mixin \BackedEnum
 */
enum SpecialistStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
}
