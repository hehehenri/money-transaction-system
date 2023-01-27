<?php

namespace Src\Infrastructure\Repositories;

use Src\Shopkeeper\Domain\DTOs\CreateShopkeeperDTO;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Infrastructure\Exceptions\InvalidShopkeeperException;
use Src\Infrastructure\Models\ShopkeeperModel;

class ShopkeeperEloquentRepository implements ShopkeeperRepository
{
    public function __construct(private readonly ShopkeeperModel $model)
    {
    }

    /** @throws InvalidShopkeeperException */
    public function create(CreateShopkeeperDTO $payload): Shopkeeper
    {
        /** @var ShopkeeperModel $Shopkeeper */
        $Shopkeeper = $this->model
            ->query()
            ->create($payload->jsonSerialize());

        return $Shopkeeper->intoEntity();
    }

    /** @throws InvalidShopkeeperException */
    public function findByEmail(Email $email): ?Shopkeeper
    {
        /** @var ?ShopkeeperModel $Shopkeeper */
        $Shopkeeper = $this->model
            ->query()
            ->where('email', (string) $email)
            ->first();

        return $Shopkeeper?->intoEntity();
    }

    /** @throws InvalidShopkeeperException */
    public function findById(ShopkeeperId $id): ?Shopkeeper
    {
        /** @var ShopkeeperModel $Shopkeeper */
        $Shopkeeper = $this->model->query()->find($id);

        return $Shopkeeper->intoEntity();
    }

    public function updateStatus(ShopkeeperId $id, Status $status): void
    {
        $this->model
            ->query()
            ->update(['status', $status->value]);
    }
}
