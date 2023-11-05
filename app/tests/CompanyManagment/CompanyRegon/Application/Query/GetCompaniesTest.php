<?php

namespace App\Tests\CompanyManagment\CompanyRegon\Application\Query;

use PHPUnit\Framework\TestCase;
use CompanyManagment\CompanyRegon\Domain\Company\Company;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyId;
use CompanyManagment\CompanyRegon\Application\Query\CompanyDTO;
use CompanyManagment\CompanyRegon\Application\Query\CompanyQuery;
use App\Tests\CompanyManagment\CompanyRegon\Doubles\InMemoryCompanyRepository;

class GetCompaniesTest extends TestCase
{
    public function testAllCompaniesAreRetunedQuety(): void
    {
        $companyOne =  Company::create(
            CompanyId::generate(),
            "070569406",
            "Test company",
            "Test voivodeship",
            "Test county",
            "Test borough",
            "Test town",
            "Test postCode",
            "Test street",
        );
        $companyTwo = Company::create(
            CompanyId::generate(),
            "010137837",
            "Test company2",
            "Test voivodeship2",
            "Test county2",
            "Test borough2",
            "Test town2",
            "Test postCode2",
            "Test street2",
        );

        $repository = new InMemoryCompanyRepository();

        $repository->store($companyOne);
        $repository->store($companyTwo);

        $companyList = (new CompanyQuery($repository))->fetchAll();

        $this->assertCount(2, $companyList);
        $this->assertInstanceOf(CompanyDTO::class, $companyList[0]);
        $this->assertInstanceOf(CompanyDTO::class, $companyList[1]);
    }
}
