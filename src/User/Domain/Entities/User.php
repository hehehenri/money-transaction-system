<?php

namespace Src\User\Domain\Entities;

use Src\Shared\ValueObjects\Email;
use Src\User\Domain\ValueObjects\Document;
use Src\User\Domain\ValueObjects\FullName;
use Src\User\Domain\ValueObjects\HashedPassword;

class User
{
    public function __construct(
        public readonly FullName $fullName,
        public readonly Document $document,
        public readonly Email $email,
        public readonly HashedPassword $password,
    ) {
    }
}
