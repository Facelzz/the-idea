<?php

declare(strict_types=1);

namespace App\Http\Requests;

interface ExtendableRequestInterface
{
    public function collectRules(): array;
}
