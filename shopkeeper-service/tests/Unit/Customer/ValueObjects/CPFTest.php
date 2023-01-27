<?php

namespace Shopkeeper\ValueObjects;

use Src\Shopkeeper\Domain\InvalidParameterException;
use Src\Shopkeeper\Domain\ValueObjects\CPF;
use Tests\TestCase;

class CPFTest extends TestCase
{
    /** @dataProvider validCPFs */
    public function testTheCPFIsValid(string $payload): void
    {
        $cpf = new CPF($payload);

        $this->assertEquals($this->removePonctuation($payload), (string) $cpf);
    }

    /** @dataProvider invalidCPFs */
    public function testTheCPFIsInvalid(string $payload): void
    {
        $this->expectException(InvalidParameterException::class);

        new CPF($payload);
    }

    /** @return array<string, array<string>> */
    public function validCPFs(): array
    {
        return [
            'starting_with_zero' => ['04784261001'],
            'with_ponctuation' => ['047.842.610-01'],
            'regular_one' => ['19247072093'],
            'regular_two' => ['45804352067'],
            'regular_three' => ['77143589047'],
        ];
    }

    /**
     * @return array<string, array<string>>
     */
    public function invalidCPFs(): array
    {
        return [
            'too_small' => ['1924707'],
            'too_long' => ['1924707209312'],
            'invalid' => ['19247075093'],
        ];
    }

    private function removePonctuation(string $payload): string
    {
        return preg_replace('/[^0-9]/', '', $payload) ?? '';
    }
}
