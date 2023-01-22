<?php

namespace Src\Customer\Domain\Repositories;

use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;

interface CustomerRepository
{
    public function create(CreateCustomerDTO $payload): Customer;
}
