<?php

namespace Src\Customer\Domain\UseCases;

class ValidateCPF
{
    public function __invoke(string $value): bool
    {
        $value = $this->removeNonNumericChars($value);

        if ($this->validateLength($value)) {
            return false;
        }

        if ($this->checkIfAllDigitsAreTheSame($value)) {
            return false;
        }

        if ($this->validateDigits($value)) {
            return false;
        }

        return true;
    }

    private function removeNonNumericChars(string $value): string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    private function validateLength(string $value): bool
    {
        return strlen($value) != 11;
    }

    private function checkIfAllDigitsAreTheSame(string $value): bool
    {
        return preg_match('/(\d)\1{10}/', $value);
    }

    private function validateDigits(string $value): bool
    {
        $firstDigit = $this->getFirstDigit($value);
        $secondDigit = $this->getSecondDigit($value);

        if ($firstDigit != $value[9] || $secondDigit != $value[10]) {
            return true;
        }

        return false;
    }

    private function getFirstDigit(string $value): int
    {
        $firstDigit = 0;

        for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
            $firstDigit += $value[$i] * $x;
        }

        return ($firstDigit % 11) < 2 ? 0 : 11 - ($firstDigit % 11);
    }

    private function getSecondDigit(string $value): int
    {
        $secondDigit = 0;

        for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
            $secondDigit += $value[$i] * $x;
        }

        return ($secondDigit % 11) < 2 ? 0 : 11 - ($secondDigit % 11);
    }
}
