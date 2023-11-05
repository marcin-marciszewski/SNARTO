<?php

namespace App\Tests\CompanyManagment\CompanyRegon\Domain\Company;

use PHPUnit\Framework\TestCase;
use CompanyManagment\CompanyRegon\Domain\Company\Company;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyId;
use App\Tests\CompanyManagment\CompanyRegon\Doubles\InMemoryCompanyRepository;

class CompanyTest extends TestCase
{
    public function testCompanyCanBeCreated(): void
    {
        $companyId = CompanyId::generate();

        $company = Company::create(
            $companyId,
            "070569406",
            "Test company",
            "Test voivodeship",
            "Test county",
            "Test borough",
            "Test town",
            "Test postCode",
            "Test street",
        );

        $this->assertSame($companyId, $company->getId());
        $this->assertSame("070569406", $company->getRegon());
        $this->assertSame("Test company", $company->getName());
        $this->assertSame("Test voivodeship", $company->getVoivodeship());
        $this->assertSame("Test county", $company->getCounty());
        $this->assertSame("Test borough", $company->getBorough());
        $this->assertSame("Test postCode", $company->getPostCode());
        $this->assertSame("Test street", $company->getStreet());
    }

    public function testAllCompaniesAreRetuned(): void
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

        $companies = $repository->getAll();

        $this->assertCount(2, $companies);
        $this->assertInstanceOf(Company::class, $companies[0]);
        $this->assertInstanceOf(Company::class, $companies[1]);
    }
}
