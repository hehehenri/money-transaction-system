<?php

namespace Src\Customer\Application;

use Src\Customer\Application\Exceptions\CustomerValidationException;
use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Infrastructure\Auth\Authenticator;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\User\Domain\Exceptions\AuthenticatableRepositoryException;
use Src\User\Domain\Exceptions\InvalidTokenException;
use Src\User\Domain\Exceptions\InvalidUserType;
use Src\User\Domain\ValueObjects\Token;

class LoginCustomer
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly Authenticator $auth,
    ) {
    }

    /**
     * @throws CustomerValidationException
     * @throws AuthenticationException
     * @throws CustomerRepositoryException
     * @throws InvalidTokenException
     * @throws AuthenticatableRepositoryException
     * @throws InvalidUserType
     */
    public function handle(LoginViewModel $payload): Token
    {
        $customer = $this->customerRepository->findByEmail($payload->email);

        if (! $customer) {
            throw CustomerValidationException::customerEmailNotFound($payload->email);
        }

        return $this->auth->login($customer, $payload->password);
    }
}
