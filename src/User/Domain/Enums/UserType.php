<?php

declare(strict_types=1);

namespace Src\User\Domain\Enums;

use Src\Customer\Domain\Entities\Customer;
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
}
