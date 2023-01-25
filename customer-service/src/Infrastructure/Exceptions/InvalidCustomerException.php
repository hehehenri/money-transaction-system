<?php

namespace Src\Infrastructure\Exceptions;

use Src\Customer\Domain\Exceptions\CustomerRepositoryException;

class InvalidCustomerException extends CustomerRepositoryException
{
    public static function failedToBuildCustomerFromDatabase(string $id): self
    {
        return new self(sprintf(
            'Failed to build from a existing database customer with ID<%s>.',
            $id
        ));
    }
}
