<?php

namespace Src\Customer\Domain\Repositories;

use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Enums\Status;
use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Infrastructure\Exceptions\InvalidCustomerException;

interface CustomerRepository
{
    /** @throws InvalidCustomerException */
    public function create(CreateCustomerDTO $payload): Customer;

    /** @throws CustomerRepositoryException */
    public function findByEmail(Email $email): ?Customer;

    /** @throws InvalidCustomerException */
    public function findById(CustomerId $id): ?Customer;

    public function updateStatus(CustomerId $id, Status $status): void;
}
