<?php

namespace Src\Transactions\Presentation\Rest\ViewModels;

use Src\Transactionables\Domain\ValueObjects\TransactionableId;
use Src\Transactions\Presentation\Rest\Requests\ListTransactionsRequest;

class ListTransactionsViewModel
{
    public function __construct(
        public readonly TransactionableId $id,
        public readonly int $perPage,
        public readonly int $page,
    ) {
    }

    public static function fromRequest(ListTransactionsRequest $request, string $id): self
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();

        return new self(
            new TransactionableId($id),
            (int) $payload['per_page'],
            (int) $payload['page']
        );
    }
}
