<?php

namespace Src\Customer\Presentation\Rest\ViewModels\Auth;

use Src\Auth\Domain\Exceptions\CustomerValidationException;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Customer\Domain\ValueObjects\PlainTextPassword;
use Src\Customer\Presentation\Rest\Requests\LoginRequest;

class LoginViewModel
{
    public function __construct(
        public readonly Email $email,
        public readonly PlainTextPassword $password,
    ) {
    }

    /** @throws CustomerValidationException */
    public static function fromRequest(LoginRequest $request): self
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();

        return new self(
            new Email($payload['email']),
            new PlainTextPassword($payload['password'])
        );
    }
}
