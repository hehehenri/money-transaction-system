<?php

namespace Customer\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Src\Infrastructure\Auth\JWTToken;
use Src\Infrastructure\Models\CustomerModel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testCustomerCanLogin(): void
    {
        $customer = $this->createCustomer();
        $token = JWTToken::encode(['email' => $customer->email]);

        $response = $this->postJson(route('customer.auth.login'), [
            'email' => 'example@example.com',
            'password' => '$trongP4ssw0rd1234',
        ]);

        $response->assertOk()
            ->assertSee($token);
    }

    /**
     * @dataProvider invalidPayload
     *
     * @param  array<string>  $errors
     */
    public function testItReturnsValidationErrors(?string $email, ?string $password, array $errors): void
    {
        $this->createCustomer();

        $response = $this->postJson(route('customer.auth.login'), ['email' => $email, 'password' => $password]);

        $response->assertSee($errors)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @return array<string, array<string|array<string>>> */
    public function invalidPayload(): array
    {
        return [
            'email_doesnt_exists' => ['this.email.doesnt@exists.com', 'good_password123', ['email']],
            'invalid_email' => ['@invalid.com', 'also4g00dp4ssw*rd', ['email']],
            'small_password' => ['example@example.com', 'small', ['password']],
            'null_values' => [null, null, ['email', 'password']],
        ];
    }

    private function createCustomer(string $email = 'example@example.com', string $password = '$trongP4ssw0rd1234'): CustomerModel
    {
        return CustomerModel::factory([
            'email' => $email,
            'password' => Hash::make($password),
        ])->create();
    }
}
