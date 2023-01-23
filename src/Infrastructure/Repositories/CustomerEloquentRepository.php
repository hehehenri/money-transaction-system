<?php

namespace Src\Infrastructure\Repositories;

use Src\Customer\Domain\DTOs\CreateCustomerDTO;
use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Infrastructure\Exceptions\InvalidCustomerException;
use Src\Infrastructure\Models\CustomerModel;
use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\HashedPassword;

class CustomerEloquentRepository implements CustomerRepository
{
    public function __construct(private readonly CustomerModel $model)
    {
    }

    public function create(CreateCustomerDTO $payload): Customer
    {
        /** @var CustomerModel $customer */
        $customer = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return new Customer(
            new Uuid($customer->id),
            new $payload->fullName,
            new $payload->cpf,
            new $payload->email,
            new HashedPassword($customer->password),
        );
    }

    /** @throws InvalidCustomerException */
    public function findByEmail(Email $email): ?Customer
    {
        /** @var ?CustomerModel $customer */
        $customer = $this->model
            ->query()
            ->where('email', (string) $email)
            ->first();

        if (! $customer) {
            return null;
        }

        return $customer->intoEntity();
    }

    /** @throws InvalidCustomerException */
    public function findById(Uuid $tokenableId): ?Customer
    {
        /** @var CustomerModel $customer */
        $customer = $this->model->query()->find($tokenableId);

        return $customer->intoEntity();
    }
}
