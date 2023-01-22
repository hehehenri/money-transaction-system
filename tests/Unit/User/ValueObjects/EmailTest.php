<?php

namespace Tests\Unit\User\ValueObjects;

use PHPUnit\Framework\TestCase;
use Src\User\Domain\Exceptions\InvalidParameterException;
use Src\User\Domain\ValueObjects\Email;

class EmailTest extends TestCase
{
    /** @dataProvider validPayloads */
    public function testEmailIsValid(): void
    {
        $payload = 'valid.email@example.com';

        $email = new Email($payload);
        $this->assertEquals($payload, (string) $email);
    }

    /** @dataProvider invalidPayloads */
    public function testEmailIsInvalid(): void
    {
        $payload = 'invalid email';

        $this->expectException(InvalidParameterException::class);
        new Email($payload);
    }

    /** @return array<string, array<string>> */
    public function validPayloads(): array
    {
        return [
            'regular_email_one' => ['gustav.elijah@awal.com'],
            'regular_email_two' => ['christopher.edwin@defjam.com'],
        ];
    }

    /** @return array<string, array<string>> */
    public function invalidPayloads(): array
    {
        return [
            'completely_out_of_format' => ['invalid'],
            'no_username' => ['@example.com'],
            'no_mail_server' => ['username@.com'],
            'no_domain' => ['username@example'],
        ];
    }
}
