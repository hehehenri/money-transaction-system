<?php

namespace Src\Shopkeeper\Presentation\Rest\ViewModels;

use Src\Auth\Domain\Exceptions\ShopkeeperValidationException;
use Src\Shopkeeper\Domain\ValueObjects\CPF;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Shopkeeper\Domain\ValueObjects\FullName;
use Src\Shopkeeper\Domain\ValueObjects\PlainTextPassword;
use Src\Shopkeeper\Presentation\Rest\Requests\RegisterRequest;

class RegisterViewModel
{
    public function __construct(
        public readonly FullName $fullName,
        public readonly Email $email,
        public readonly CPF $cpf,
        public readonly PlainTextPassword $password,
    ) {
    }

    /**
     * @throws ShopkeeperValidationException
     */
    public static function fromRequest(RegisterRequest $request): self
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();

        return new self(
            new FullName($payload['full_name']),
            new Email($payload['email']),
            new CPF($payload['cpf']),
            new PlainTextPassword($payload['password'])
        );
    }
}
