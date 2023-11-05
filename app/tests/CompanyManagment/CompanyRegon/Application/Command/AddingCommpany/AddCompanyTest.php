<?php

namespace App\Tests\CompanyManagment\CompanyRegon\Application\Command\AddingCommpany;

use App\Tests\CompanyManagment\CompanyRegon\Doubles\InMemoryCompanyRepository;
use CompanyManagment\CompanyRegon\Application\Command\AddingCommpany\AddCompanyCommand;
use CompanyManagment\CompanyRegon\Application\Command\AddingCommpany\AddCompanyHandler;
use CompanyManagment\CompanyRegon\Domain\Company\AddCompanyService;
use PHPUnit\Framework\TestCase;

class AddCompanyTest extends TestCase
{
    public function testCompanyCanBeAdded(): void
    {
        $command = new AddCompanyCommand('070569406');

        $repository = new InMemoryCompanyRepository();

        $handler = new AddCompanyHandler(new AddCompanyService($repository));
        $handler($command);

        $company = $repository->getAll()[0];

        $this->assertSame($company->getRegon(), '070569406');
    }
}
