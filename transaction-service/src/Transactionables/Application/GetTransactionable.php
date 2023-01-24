<?php

namespace Src\Transactionables\Application;

use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class GetTransactionable
{
    public function __construct(private readonly TransactionableRepository $repository)
    {
    }

    /** @throws TransactionableNotFoundException */
    public function handle(ProviderId $providerId, Provider $provider): Transactionable
    {
        $transactionable = $this->repository->get($providerId, $provider);

        if (! $transactionable) {
            throw TransactionableNotFoundException::providerInformation($providerId, $provider);
        }

        return $transactionable;
    }
}
