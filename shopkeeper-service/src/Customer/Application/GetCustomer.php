<?php

namespace Src\Shopkeeper\Application;

use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Infrastructure\Exceptions\InvalidShopkeeperException;

class GetShopkeeper
{
    public function __construct(private readonly ShopkeeperRepository $repository)
    {
    }

    /** @throws InvalidShopkeeperException */
    public function byId(ShopkeeperId $id): Shopkeeper
    {
        $Shopkeeper = $this->repository->findById($id);

        if (! $Shopkeeper) {
            throw InvalidShopkeeperException::idNotFound($id);
        }

        return $Shopkeeper;
    }

    /** @throws InvalidShopkeeperException */
    public function byEmail(Email $email): Shopkeeper
    {
        $Shopkeeper = $this->repository->findByEmail($email);

        if (! $Shopkeeper) {
            throw InvalidShopkeeperException::emailNotFound($email);
        }

        return $Shopkeeper;
    }
}
