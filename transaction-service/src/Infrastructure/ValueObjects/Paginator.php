<?php

namespace Src\Infrastructure\ValueObjects;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContracts;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Shared\Constraints\Paginator as PaginatorContract;

class Paginator extends LengthAwarePaginator implements PaginatorContract
{
    public static function paginate(LengthAwarePaginatorContracts $lengthAwarePaginator): self
    {
        return new self(
            $lengthAwarePaginator->items(),
            $lengthAwarePaginator->total(),
            $lengthAwarePaginator->perPage(),
            $lengthAwarePaginator->currentPage()
        );
    }
}
