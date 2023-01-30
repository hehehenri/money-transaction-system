<?php

namespace Customer\Auth;

use Avlima\PhpCpfCnpjGenerator\Generator as DocumentGenerator;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @throws Exception */
    public function testItRegisterUser(): void
    {
        $response = $this->route([
            'full_name' => 'Valid Name',
            'cpf' => DocumentGenerator::cpf(),
            'email' => 'example@example.com',
            'password' => 'v4l1d_P4$$w0rd.',
            'password_confirmation' => 'v4l1d_P4$$w0rd.',
        ]);

        $response->assertCreated();
    }

    /**
     * @dataProvider invalidPayload
     *
     * @param  array<string, null|string>  $payload
     */
    public function testItReturnsValidaitonErrors(array $payload): void
    {
        $response = $this->route($payload);

        $response->assertSee(array_keys($payload)[0])
            ->assertUnprocessable();
    }

    /** @return array<string, array<string, null|string>> */
    public function invalidPayload(): array
    {
        return [
            'invalid_full_name_format' => [['full_name' => 'Name. With Points']],
            'invalid_cpf' => [['cpf' => '85667017088']],
            'invalid_email_format' => [['email' => '@poggers.com']],
            'small_password' => [['password' => 'small']],
            'null_values' => [['full_name' => null, 'cpf' => null, 'email' => null, 'password' => null]],
        ];
    }

    private function route(array $payload): TestResponse
    {
        return $this->postJson(route('customer.auth.register'), $payload);
    }
}
