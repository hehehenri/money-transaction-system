<?php

namespace Src\Infrastructure\Exceptions;

use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\Customer\Domain\ValueObjects\CustomerId;

class InvalidCustomerException extends CustomerRepositoryException
{
    public static function failedToBuildCustomerFromDatabase(string $id): self
    {
        return new self(sprintf(
            'Failed to build from a existing database customer with ID<%s>.',
            $id
        ));
    }

    public static function notFound(CustomerId $id): self
    {
        return new self(sprintf('Customer with ID<%s> was not found.', $id));
    }
}
