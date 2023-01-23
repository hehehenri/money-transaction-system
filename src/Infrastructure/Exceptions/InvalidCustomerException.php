<?php

namespace Src\Infrastructure\Exceptions;

use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\Shared\ValueObjects\Uuid;

class InvalidCustomerException extends CustomerRepositoryException
{
    public static function failedToBuildCustomerFromDatabase(Uuid $id): self
    {
        return new self(sprintf(
            'Failed to build customer from a existing database customer with ID<%s>.',
            $id
        ));
    }
}
