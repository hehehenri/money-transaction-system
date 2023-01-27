<?php

namespace Src\Ledger\Application;

use Src\Ledger\Application\Exceptions\InvalidLedger;
use Src\Ledger\Domain\Entities\Ledger;
use Src\Ledger\Domain\Repository\LedgerRepository;
use Src\Transactionables\Application\GetTransactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

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
    public function byTransactionable(ProviderId $providerId, Provider $provider): Ledger
    {
        $transactionable = $this->getTransactionable->byProvider($providerId, $provider);

        $ledger = $this->repository->getByTransactionable($transactionable);

        if (! $ledger) {
            throw InvalidLedger::transactionableIdNotFound($transactionable->providerId);
        }

        return $ledger;
    }
}
