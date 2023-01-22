<?php

namespace Src\Customer\Presentation\Rest\ViewModels;

use Src\Customer\Domain\ValueObjects\CPF;
use Src\User\Domain\Exceptions\InvalidParameterException;
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
     * @param  array<string, string>  $payload
     *
     * @throws InvalidParameterException
     */
    public static function fromRequest(array $payload): self
    {
        $fullName = new FullName($payload['full_name']);
        $email = new Email($payload['email']);
        $cpf = new CPF($payload['cpf']);
        $password = new PlainTextPassword($payload['password']);

        return new self($fullName, $email, $cpf, $password);
    }
}
