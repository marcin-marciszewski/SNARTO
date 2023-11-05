<?php

declare(strict_types=1);

namespace CompanyManagment\CompanyRegon\Application\Command\AddingCommpany;

use CompanyManagment\CompanyRegon\Application\Command\Command;

class AddCompanyCommand implements Command
{
    public function __construct(
        private string $regon,
    ) {
    }

    public function getRegon(): string
    {
        return $this->regon;
    }
}
