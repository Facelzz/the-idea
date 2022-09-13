<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Specialist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetActiveSpecialistsAction
{
    public function execute(int $page = 1, int $perPage = 20, ?int $forSpeciality = null): LengthAwarePaginator
    {
        $query = Specialist::active()->with('speciality');

        if ($forSpeciality) {
            $query->where('speciality_id', $forSpeciality);
        }

        return $query->paginate(perPage: $perPage, page: $page);
    }
}
