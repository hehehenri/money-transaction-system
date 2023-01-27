<?php

namespace Src\Auth\Application;

use Illuminate\Support\Facades\Hash;
use Src\Shopkeeper\Domain\DTOs\CreateShopkeeperDTO;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Shopkeeper\Domain\Enums\Status;
use Src\Shopkeeper\Domain\Repositories\ShopkeeperRepository;
use Src\Shopkeeper\Domain\ValueObjects\HashedPassword;
use Src\Shopkeeper\Domain\ValueObjects\PlainTextPassword;
use Src\Shopkeeper\Presentation\Rest\ViewModels\RegisterViewModel;

class RegisterShopkeeper
{
    public function __construct(private readonly ShopkeeperRepository $ShopkeeperRepository)
    {
    }

    public function handle(RegisterViewModel $payload): Shopkeeper
    {
        $hashedPassword = $this->hashPassword($payload->password);

        $dto = new CreateShopkeeperDTO(
            $payload->fullName,
            $payload->email,
            $payload->cpf,
            $hashedPassword,
            Status::PENDING
        );

        return $this->ShopkeeperRepository->create($dto);
    }

    private function hashPassword(PlainTextPassword $password): HashedPassword
    {
        $hashed = Hash::make((string) $password);

        return new HashedPassword($hashed);
    }
}
