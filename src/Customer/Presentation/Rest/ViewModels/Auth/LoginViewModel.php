<?php

namespace Src\Customer\Presentation\Rest\ViewModels\Auth;

use Src\Customer\Presentation\Rest\Requests\LoginRequest;
use Src\User\Domain\Exceptions\InvalidParameterException;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\PlainTextPassword;

class LoginViewModel
{
    public function __construct(
        public readonly Email $email,
        public readonly PlainTextPassword $password,
    ) {
    }

    /** @throws InvalidParameterException */
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
