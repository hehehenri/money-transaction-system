<?php

namespace Tests\Unit\Transactionables\Entities;

use Illuminate\Support\Str;
use Src\Transactionables\Domain\Entities\Sender;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactionables\Domain\ValueObjects\SenderId;
use Tests\TestCase;

class SenderTest extends TestCase
{
    /*
     * @dataProvider validPayload
     */
    public function canCreateSender(SenderId $id, Provider $provider, ProviderId $providerId)
    {
        $this->expectNotToPerformAssertions();

        $sender = new Sender($id, $provider, $providerId);
    }

    /**
     * @dataProvider invalidPayload
     */
    public function testCannotCreateSender(SenderId $id, Provider $provider, ProviderId $providerId)
    {
        $this->expectException(InvalidTransactionableException::class);

        new Sender($id, $provider, $providerId);
    }

    /** @return array<string, array{SenderId, Provider, ProviderId}> */
    public function validPayload(): array
    {
        return [
            'create_from_customer' => [
                new SenderId(Str::uuid()->toString()),
                Provider::CUSTOMERS,
                new ProviderId(Str::uuid()->toString()),
            ],
        ];
    }

    /** @return array<string, array{SenderId, Provider, ProviderId}> */
    public function invalidPayload(): array
    {
        return [
            'create_from_shopkeeper' => [
                new SenderId(Str::uuid()->toString()),
                Provider::SHOPKEEPERS,
                new ProviderId(Str::uuid()->toString()),
            ],
        ];
    }
}
