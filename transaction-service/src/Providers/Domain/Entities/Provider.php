<?php

namespace Src\Providers\Domain\Entities;

use Src\Providers\Domain\ValueObjects\Name;
use Src\Providers\Domain\ValueObjects\ProviderId;

class Provider
{
    public function __construct(
        public readonly ProviderId $id,
        public readonly Name $name,
    ) {
    }
}
