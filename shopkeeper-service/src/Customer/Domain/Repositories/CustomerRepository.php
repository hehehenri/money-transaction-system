<?php

namespace Src\Shopkeeper\Domain\Repositories;

use Src\Shopkeeper\Domain\DTOs\CreateShopkeeperDTO;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\Exceptions\ShopkeeperRepositoryException;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Infrastructure\Exceptions\InvalidShopkeeperException;

interface ShopkeeperRepository
{
    /** @throws InvalidShopkeeperException */
    public function create(CreateShopkeeperDTO $payload): Shopkeeper;

    /** @throws ShopkeeperRepositoryException */
    public function findByEmail(Email $email): ?Shopkeeper;

    /** @throws InvalidShopkeeperException */
    public function findById(ShopkeeperId $id): ?Shopkeeper;

    public function updateStatus(ShopkeeperId $id, Status $status): void;
}
