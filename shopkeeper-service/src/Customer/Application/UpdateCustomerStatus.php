<?php

namespace Src\Shopkeeper\Application;

use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;

class UpdateShopkeeperStatus
{
    public function __construct(private readonly ShopkeeperRepository $repository)
    {
    }

    public function handle(ShopkeeperId $id, Status $status): void
    {
        $this->repository->updateStatus($id, $status);
    }
}
