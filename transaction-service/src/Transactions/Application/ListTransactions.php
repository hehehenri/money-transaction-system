<?php

namespace Src\Transactions\Application;

use Src\Shared\Constraints\Paginator;
use Src\Transactionables\Application\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Application\GetTransactionable;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Src\Transactions\Domain\Repositories\TransactionRepository;
use Src\Transactions\Presentation\Rest\ViewModels\ListTransactionsViewModel;

class ListTransactions
{
    public function __construct(
        private readonly GetTransactionable $getTransactionable,
        private readonly TransactionRepository $repository,
    ) {
    }

    /**
     * @throws InvalidTransactionableException
     * @throws TransactionableNotFoundException
     */
    public function paginated(ListTransactionsViewModel $payload): Paginator
    {
        $transactionable = $this->getTransactionable->byProvider($payload->providerId, $payload->provider);

        return $this->repository->getPaginated($transactionable, $payload->perPage, $payload->page);
    }
}
