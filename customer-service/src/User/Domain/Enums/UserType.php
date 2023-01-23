<?php

declare(strict_types=1);

namespace Src\User\Domain\Enums;

use Src\Customer\Domain\Entities\Customer;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\User\Domain\Entities\User;
use Src\User\Domain\Exceptions\InvalidUserType;

enum UserType: string
{
    case CUSTOMER = 'customer';
    case SHOPKEEPER = 'shopkeeper';

    /** @throws InvalidUserType */
    public static function fromUser(User $user): self
    {
        return match ($type = get_class($user)) {
            Customer::class => self::CUSTOMER,
            default => throw InvalidUserType::notImplemented($type)
        };
    }

    /**
     * @throws InvalidUserType
     */
    public function repository(): CustomerRepository
    {
        /** @var CustomerRepository $repository */
        $repository = match ($this) {
            self::CUSTOMER => app(CustomerRepository::class),
            default => throw InvalidUserType::notImplemented($this->value)
        };

        return $repository;
    }
}
