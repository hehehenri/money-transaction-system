<?php

namespace Src\Transactionables\Domain\Exceptions;

use Exception;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class TransactionableNotFoundException extends Exception
{
    public static function providerInformation(
        ProviderId $providerId,
        Provider $provider
    ): self {
        return new self(sprintf(
            'Transaction from provider<%s> and id<%s>',
            $provider->value,
            $providerId
        ));
    }
}
