<?php

namespace Src\Shopkeeper\Domain\DTOs;

use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\ValueObjects\CPF;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Shopkeeper\Domain\ValueObjects\FullName;
use Src\Shopkeeper\Domain\ValueObjects\HashedPassword;

class CreateShopkeeperDTO
{
    public function __construct(
        public readonly FullName $fullName,
        public readonly Email $email,
        public readonly CPF $cpf,
        public readonly HashedPassword $password,
        public readonly Status $status
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
            'status' => $this->status->value,
        ];
    }
}
