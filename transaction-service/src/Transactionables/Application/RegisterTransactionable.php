<?php

namespace Src\Transactionables\Application;

use DB;
use Src\Ledger\Application\CreateLedger;
use Src\Ledger\Domain\DTOs\LedgerDTO;
use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Domain\ViewModels\RegisterTransactionableViewModel;

class RegisterTransactionable
{
    public function __construct(
        private readonly TransactionableRepository $repository,
        private readonly CreateLedger $createLedger,
    ) {
    }

    public function handle(RegisterTransactionableViewModel $payload): Transactionable
    {
        $transactionableDTO = new TransactionableDTO($payload->providerId, $payload->provider);

        /** @phpstan-ignore-next-line */
        return DB::transaction(function () use ($transactionableDTO) {
            $transactionable = $this->repository->register($transactionableDTO);

            $ledgerDTO = new LedgerDTO($transactionable);

            $this->createLedger->create($ledgerDTO);

            return $transactionable;
        });
    }
}
