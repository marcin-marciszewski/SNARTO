<?php

namespace CompanyManagment\CompanyRegon\Domain\Company;

use CompanyManagment\CompanyRegon\Domain\Company\Company;

interface CompanyRepository
{
    public function store(Company $company): void;

    /**
     * @return Appointment[]
     */
    public function getAll(): array;
}
