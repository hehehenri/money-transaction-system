<?php

namespace Src\Customer\Domain\Repositories;

use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\User\Domain\Repositories\AuthenticatableRepository;
use Src\User\Domain\ValueObjects\Email;

interface CustomerRepository extends AuthenticatableRepository
{
    public function create(CreateCustomerDTO $payload): Customer;

    /** @throws CustomerRepositoryException */
    public function findByEmail(Email $email): ?Customer;
}
