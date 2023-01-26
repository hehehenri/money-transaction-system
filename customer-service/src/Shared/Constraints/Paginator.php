<?php

namespace Src\Shared\Constraints;

interface Paginator
{
    /**
     * Determine the total number of items in the data store.
     *
     * @return int
     */
    public function total();

    /**
     * Get all of the items being paginated.
     *
     * @return array
     *
     * @phpstan-ignore-next-line
     */
    public function items();

    /**
     * Determine how many items are being shown per page.
     *
     * @return int
     */
    public function perPage();

    /**
     * Determine the current page being paginated.
     *
     * @return int
     */
    public function currentPage();
}
