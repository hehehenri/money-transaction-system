<?php

namespace Src\Customer\Domain\Entities;

use Src\Shared\ValueObjects\Uuid;
use Src\User\Domain\Entities\User;
use Src\User\Domain\ValueObjects\Document;
use Src\User\Domain\ValueObjects\Email;
use Src\User\Domain\ValueObjects\FullName;
use Src\User\Domain\ValueObjects\HashedPassword;

final class Customer extends User
{
    public function __construct(
        Uuid $id,
        FullName $fullName,
        Document $document,
        Email $email,
        HashedPassword $password
    ) {
        parent::__construct($id, $fullName, $document, $email, $password);
    }
}
