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

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'full_name' => (string) $this->fullName,
            'email' => (string) $this->email,
            'document' => (string) $this->cpf,
            'password' => (string) $this->password,
        ];
    }
}
