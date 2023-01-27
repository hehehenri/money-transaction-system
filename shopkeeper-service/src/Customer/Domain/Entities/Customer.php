<?php

namespace Src\Shopkeeper\Domain\Entities;

use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shopkeeper\Domain\ValueObjects\Document;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Shopkeeper\Domain\ValueObjects\FullName;
use Src\Shopkeeper\Domain\ValueObjects\HashedPassword;

final class Shopkeeper
{
    public function __construct(
        public readonly ShopkeeperId $id,
        public readonly Email $email,
        public readonly HashedPassword $password,
        public readonly FullName $fullName,
        public readonly Document $document,
        public readonly Status $status,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->id,
            'email' => (string) $this->email,
            'full_name' => (string) $this->fullName,
            'document' => (string) $this->document,
            'status' => $this->status->value,
        ];
    }
}
