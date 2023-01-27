<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Infrastructure\Models\TokenModel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asShopkeeper(Shopkeeper $Shopkeeper): self
    {
        /** @var TokenModel $model */
        $model = TokenModel::factory()
            ->Shopkeeper($Shopkeeper)
            ->create();

        $token = $model->token;

        return $this->withToken($token);
    }
}
