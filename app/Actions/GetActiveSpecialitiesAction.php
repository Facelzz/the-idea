<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\{Specialist, Speciality};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetActiveSpecialitiesAction
{
    public function execute(int $page = 1, int $perPage = 20): LengthAwarePaginator
    {
        return Speciality::active()->paginate(perPage: $perPage, page: $page);
    }
}
