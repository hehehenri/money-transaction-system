<?php

namespace Src\Customer\Presentation\Rest\ViewModels;

use Src\Customer\Domain\ValueObjects\CPF;
use Src\Customer\Presentation\Rest\Requests\RegisterRequest;
use Src\User\Domain\Exceptions\UserValidationException;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\FullName;
use Src\User\Domain\ValueObjects\PlainTextPassword;

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
     * @throws UserValidationException
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
