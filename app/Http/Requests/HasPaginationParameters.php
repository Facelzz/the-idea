<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * @property int|string $page
 * @property int|string $perPage
 */
trait HasPaginationParameters
{
    public function paginationCollectableRules(): array
    {
        return [
            'page' => ['bail', 'sometimes', 'nullable', 'int', 'min:1'],
            'perPage' => ['bail', 'sometimes', 'nullable', 'int', 'min:1'],
        ];
    }

    public function getPage(): int
    {
        return $this->page ? (int) $this->page : 1;
    }

    public function getPerPage(): int
    {
        return $this->perPage ? (int) $this->perPage : 20;
    }
}
