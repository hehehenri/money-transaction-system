<?php

namespace Src\Transactionables\Application;

use Src\Transactionables\Domain\DTOs\TransactionableDTO;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Domain\ViewModels\RegisterTransactionableViewModel;

class RegisterTransactionable
{
    public function __construct(private readonly TransactionableRepository $repository)
    {
    }

    public function handle(RegisterTransactionableViewModel $payload): Transactionable
    {
        $dto = new TransactionableDTO(
            $payload->providerId,
            $payload->provider
        );

        return $this->repository->register($dto);
    }
}
