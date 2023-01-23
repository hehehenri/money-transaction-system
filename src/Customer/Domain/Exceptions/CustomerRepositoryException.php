<?php

namespace Src\Customer\Domain\Exceptions;

use Src\User\Domain\Exceptions\AuthenticatableRepositoryException;

abstract class CustomerRepositoryException extends AuthenticatableRepositoryException
{
}
