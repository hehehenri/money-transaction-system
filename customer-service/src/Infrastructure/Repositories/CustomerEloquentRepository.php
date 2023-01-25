<?php

namespace Src\Infrastructure\Repositories;

use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Infrastructure\Exceptions\InvalidCustomerException;
use Src\Infrastructure\Models\CustomerModel;

class CustomerEloquentRepository implements CustomerRepository
{
    public function __construct(private readonly CustomerModel $model)
    {
    }

    /** @throws InvalidCustomerException */
    public function create(CreateCustomerDTO $payload): Customer
    {
        /** @var CustomerModel $customer */
        $customer = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return $customer->intoEntity();
    }

    /** @throws InvalidCustomerException */
    public function findByEmail(Email $email): ?Customer
    {
        /** @var ?CustomerModel $customer */
        $customer = $this->model
            ->query()
            ->where('email', (string) $email)
            ->first();

        return $customer?->intoEntity();
    }

    /** @throws InvalidCustomerException */
    public function findById(CustomerId $id): ?Customer
    {
        /** @var CustomerModel $customer */
        $customer = $this->model->query()->find($id);

        return $customer->intoEntity();
    }
}
