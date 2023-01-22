<?php

namespace Src\User\Domain\Entities;

use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\ValueObjects\Document;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\FullName;
use Src\User\Domain\ValueObjects\HashedPassword;

abstract class User
{
    public function __construct(
        public readonly Uuid $id,
        public readonly FullName $fullName,
        public readonly Document $document,
        public readonly Email $email,
        public readonly HashedPassword $password,
    ) {
    }
}
