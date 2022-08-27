<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Specialist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetActiveSpecialistsAction
{
    public function execute(int $page = 1, int $perPage = 20): LengthAwarePaginator
    {
        return Specialist::active()->paginate(perPage: $perPage, page: $page);
    }
}
