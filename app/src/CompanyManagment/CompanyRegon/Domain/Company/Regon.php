<?php

namespace CompanyManagment\CompanyRegon\Domain\Company;

use CompanyManagment\CompanyRegon\Domain\Company\Exception\RegonInvalid;

class Regon
{
    private function __construct(
        private string $regon,
    ) {
    }

    public static function create(
        string $regon,
    ): self {
        if (!self::validateREGON($regon)) {
            throw new RegonInvalid("Invalid regon number.");
        }
        return new self($regon);
    }

    private static function validateREGON($regon): bool
    {
        $weights = [8, 9, 2, 3, 4, 5, 6, 7];
        $regon = str_replace([' ', '-', '.'], '', $regon);
        $length = strlen($regon);

        if ($length !== 9 || !ctype_digit($regon)) {
            return false;
        }

        $sum = 0;
        $weightsIndex = 0;

        for ($i = 0; $i < $length - 1; $i++) {
            $digit = intval($regon[$i]);
            $sum += $digit * $weights[$weightsIndex];
            $weightsIndex = ($weightsIndex + 1) % 8;
        }

        $remainder = $sum % 11 == 10 ? 0 : $sum % 11;
        return $regon[8] == $remainder;
    }

    public function getRegon(): string
    {
        return $this->regon;
    }
}
