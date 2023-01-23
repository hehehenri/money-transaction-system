<?php

declare(strict_types=1);

namespace Src\Transactionables\Domain\Entities;

use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\SenderId;

final class Sender extends Transactionable
{
    /**
     * @throws InvalidTransactionableException
     */
    public function __construct(SenderId $id, Provider $provider, ProviderId $providerId)
    {
        if ($provider === Provider::SHOPKEEPERS) {
            throw InvalidTransactionableException::providerCannotBeSender($provider);
        }

        parent::__construct($id, $providerId, $provider);
    }
}
