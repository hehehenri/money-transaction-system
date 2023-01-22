<?php

namespace Src\Customer\Domain\Repositories;

use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;
use Src\User\Domain\ValueObjects\Email;

interface CustomerRepository
{
    public function create(CreateCustomerDTO $payload): Customer;

    public function findByEmail(Email $email): ?Customer;
}
