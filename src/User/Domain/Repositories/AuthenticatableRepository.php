<?php

namespace Src\User\Domain\Repositories;

use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\Entities\AuthenticatableUser;
use Src\User\Domain\Exceptions\AuthenticatableRepositoryException;

interface AuthenticatableRepository
{
    /** @throws AuthenticatableRepositoryException */
    public function findById(Uuid $tokenableId): ?AuthenticatableUser;
}
