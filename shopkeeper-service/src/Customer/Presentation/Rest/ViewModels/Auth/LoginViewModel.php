<?php

namespace Src\Shopkeeper\Presentation\Rest\ViewModels\Auth;

use Src\Auth\Domain\Exceptions\ShopkeeperValidationException;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Shopkeeper\Domain\ValueObjects\PlainTextPassword;
use Src\Shopkeeper\Presentation\Rest\Requests\LoginRequest;

class LoginViewModel
{
    public function __construct(
        public readonly Email $email,
        public readonly PlainTextPassword $password,
    ) {
    }

    /** @throws ShopkeeperValidationException */
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
