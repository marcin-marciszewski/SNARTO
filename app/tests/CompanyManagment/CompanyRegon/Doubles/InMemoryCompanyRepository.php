<?php

namespace App\Tests\CompanyManagment\CompanyRegon\Doubles;

use CompanyManagment\CompanyRegon\Domain\Company\Company;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyRepository;

class InMemoryCompanyRepository implements CompanyRepository
{
    private array $companies = [];

    public function store(Company $company): void
    {
        $this->companies[] = $company;
    }

    public function getAll(): array
    {
        return $this->companies;
    }
}
