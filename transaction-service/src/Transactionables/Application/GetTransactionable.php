<?php

namespace Src\Transactionables\Application;

use Src\Transactionables\Application\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\Entities\Transactionable;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Src\Transactionables\Domain\Repositories\TransactionableRepository;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\TransactionableId;
use Src\Transactions\Domain\ValueObjects\TransactionId;

class GetTransactionable
{
    public function __construct(private readonly TransactionableRepository $repository)
    {
    }

    /** @throws TransactionableNotFoundException */
    public function byProvider(ProviderId $providerId, Provider $provider): Transactionable
    {
        $transactionable = $this->repository->get($providerId, $provider);

        if (! $transactionable) {
            throw TransactionableNotFoundException::providerInformation($providerId, $provider);
        }

        return $transactionable;
    }

    /**
     * @throws InvalidTransactionableException
     */
    public function byTransaction(TransactionId $id): Transactionable
    {
        $transactionable = $this->repository->getByTransactionId($id);

        if (! $transactionable) {
            throw InvalidTransactionableException::transactionNotFound($id);
        }

        return $transactionable;
    }

    /** @throws InvalidTransactionableException */
    public function byId(TransactionableId $id): Transactionable
    {
        $transactionable = $this->repository->getById($id);

        if (! $transactionable) {
            throw InvalidTransactionableException::idNotFound($id);
        }

        return $transactionable;
    }
}
