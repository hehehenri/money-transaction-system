<?php

namespace Tests\Unit\User\ValueObjects;

use Src\User\Domain\Exceptions\InvalidParameterException;
use Src\User\Domain\ValueObjects\FullName;
use Tests\TestCase;

class FullNameTest extends TestCase
{
    /** @dataProvider validPayloads */
    public function testFullNameIsValid(string $validPayload): void
    {
        $fullName = new FullName($validPayload);

        $this->assertEquals($validPayload, (string) $fullName);
    }

    /** @dataProvider invalidPayloads */
    public function testFullNameIsInvalid(string $invalidPayload): void
    {
        $this->expectException(InvalidParameterException::class);

        new FullName($invalidPayload);
    }

    /** @return array<string, array<string>> */
    public function validPayloads(): array
    {
        return [
            'regular_name' => ['Gustav Elijah Ahr'],
            'using_hyphen' => ['Jacques-Bermon Webster II'],
            'using_accents' => ['Rákim Mayers'],
        ];
    }

    /** @return array<string, array<string>> */
    public function invalidPayloads(): array
    {
        return [
            'too_short' => ['pi'],
            'too_long' => [str_repeat('a', 155)],
            'invalid_characters' => ['Aubrey*Drake'],
        ];
    }
}
