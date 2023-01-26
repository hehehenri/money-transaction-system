<?php

namespace Src\Customer\Application;

use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Infrastructure\Exceptions\InvalidCustomerException;

class GetCustomer
{
    public function __construct(private readonly CustomerRepository $repository)
    {
    }

    /** @throws InvalidCustomerException */
    public function byId(CustomerId $id): Customer
    {
        $customer = $this->repository->findById($id);

        if (! $customer) {
            throw InvalidCustomerException::idNotFound($id);
        }

        return $customer;
    }

    /** @throws InvalidCustomerException */
    public function byEmail(Email $email): Customer
    {
        $customer = $this->repository->findByEmail($email);

        if (! $customer) {
            throw InvalidCustomerException::emailNotFound($email);
        }

        return $customer;
    }
}
