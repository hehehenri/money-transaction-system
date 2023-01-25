<?php

namespace Src\Auth\Application;

use Src\Auth\Application\Exceptions\CustomerValidationException;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Infrastructure\Auth\Authenticator;
use Src\Infrastructure\Exceptions\AuthenticationException;

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
