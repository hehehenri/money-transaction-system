<?php

namespace Src\Ledger\Application;

use Src\Ledger\Application\Exceptions\InvalidLedger;
use Src\Ledger\Domain\Entities\Ledger;
use Src\Ledger\Domain\Repository\LedgerRepository;
use Src\Ledger\Presentation\Rest\ViewModels\ShowLedgerViewModel;
use Src\Transactionables\Application\GetTransactionable;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;

class GetLedger
{
    public function __construct(
        private readonly GetTransactionable $getTransactionable,
        private readonly LedgerRepository $repository
    ) {
    }

    /**
     * @throws InvalidLedger
     * @throws TransactionableNotFoundException
     */
    public function byTransactionable(ShowLedgerViewModel $payload): Ledger
    {
        $transactionable = $this->getTransactionable->byProvider($payload->providerId, $payload->provider);

        $ledger = $this->repository->getByTransactionable($transactionable);

        if (! $ledger) {
            throw InvalidLedger::transactionableIdNotFound($transactionable->providerId);
        }

        return $ledger;
    }
}
