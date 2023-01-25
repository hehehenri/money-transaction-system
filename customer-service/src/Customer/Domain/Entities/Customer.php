<?php

namespace Src\Customer\Domain\Entities;

use Src\Customer\Domain\Enums\Status;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Customer\Domain\ValueObjects\Document;
use Src\Customer\Domain\ValueObjects\Email;
use Src\Customer\Domain\ValueObjects\FullName;
use Src\Customer\Domain\ValueObjects\HashedPassword;

final class Customer
{
    public function __construct(
        public readonly CustomerId $id,
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
