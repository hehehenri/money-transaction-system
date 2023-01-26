<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Models\TokenModel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function asCustomer(Customer $customer): self
    {
        /** @var TokenModel $model */
        $model = TokenModel::factory()
            ->customer($customer)
            ->create();

        $token = $model->token;

        return $this->withToken($token);
    }
}
