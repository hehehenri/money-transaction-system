<?php

namespace Src\Customer\Application;

use Src\Customer\Application\Exceptions\InvalidParameterException;
use Src\Customer\Domain\Repositories\CustomerRepository;
use Src\Customer\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Infrastructure\Auth\Authenticator;
use Src\Infrastructure\Auth\ValueObjects\JWTToken;
use Src\Infrastructure\Exceptions\AuthenticationException;

class LoginCustomer
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly Authenticator $auth,
    ) {
    }

    /**
     * @throws InvalidParameterException
     * @throws AuthenticationException
     */
    public function handle(LoginViewModel $payload): JWTToken
    {
        $customer = $this->customerRepository->findByEmail($payload->email);

        if (! $customer) {
            throw InvalidParameterException::customerEmailNotFound($payload->email);
        }

        return $this->auth->login($customer, $payload->password);
    }
}
