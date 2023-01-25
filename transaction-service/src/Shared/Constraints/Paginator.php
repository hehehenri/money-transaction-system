<?php

namespace Src\Shared\Constraints;

interface Paginator
{
    public function total(): int;

    public function url(int $page): string;

    /** @phpstan-ignore-next-line */
    public function appends(array|string|null $key, $value = null): self;

    public function fragment(?string $fragment = null): self|string|null;

    public function nextPageUrl(): null|string;

    public function previousPageUrl(): ?string;

    /** @phpstan-ignore-next-line */
    public function items(): array;

    public function perPage(): int;

    public function currentPage(): int;

    public function hasPages(): bool;

    public function hasMorePages(): bool;

    public function path(): ?string;

    public function isEmpty(): bool;

    public function isNotEmpty(): bool;

    /** @phpstan-ignore-next-line */
    public function render(?string $view = null, array $data = []): string;
}
