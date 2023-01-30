<?php

namespace Src\Customer\Presentation\Rest\ViewModels;

use Src\Auth\Domain\Exceptions\CustomerValidationException;
use Src\Customer\Domain\InvalidParameterException;
use Src\Customer\Domain\ValueObjects\CPF;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Customer\Domain\ValueObjects\FullName;
use Src\Customer\Domain\ValueObjects\PlainTextPassword;
use Src\Customer\Presentation\Rest\Requests\RegisterRequest;

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
     * @throws CustomerValidationException
     * @throws InvalidParameterException
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
