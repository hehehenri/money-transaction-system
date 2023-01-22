<?php

namespace Src\Customer\Domain\DTOs;

use Src\Customer\Domain\ValueObjects\CPF;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\FullName;
use Src\User\Domain\ValueObjects\HashedPassword;

class CreateCustomerDTO
{
    public function __construct(
        public readonly FullName $fullName,
        public readonly Email $email,
        public readonly CPF $cpf,
        public readonly HashedPassword $password,
    ) {
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->fullName,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'password' => $this->password,
        ];
    }
}
