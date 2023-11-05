<?php

namespace  CompanyManagment\CompanyRegon\Infrastructure;

use Doctrine\DBAL\Connection;
use CompanyManagment\CompanyRegon\Domain\Company\Company;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyId;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyRepository;

class DbalCompanyRepository implements CompanyRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function store(Company $company): void
    {
        $stmt = $this->connection->prepare('
            INSERT INTO companies (id, regon, name, voivodeship, county, borough, town, postcode, street)
            VALUES (:id, :regon, :name, :voivodeship, :county, :borough, :town, :postcode, :street) 
        ');

        $stmt->bindValue('id', $company->getId()->toString());
        $stmt->bindValue('regon', $company->getRegon());
        $stmt->bindValue('name', $company->getName());
        $stmt->bindValue('voivodeship', $company->getVoivodeship());
        $stmt->bindValue('county', $company->getBorough());
        $stmt->bindValue('borough', $company->getBorough());
        $stmt->bindValue('town', $company->getTown());
        $stmt->bindValue('postcode', $company->getPostCode());
        $stmt->bindValue('street', $company->getStreet());

        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM companies
        ');


        $result = $stmt->executeQuery();
        $companies = [];

        while ($row = $result->fetchAssociative()) {
            $companies[] = Company::create(
                CompanyId::fromString($row['id']),
                $row['regon'],
                $row['name'],
                $row['voivodeship'],
                $row['county'],
                $row['borough'],
                $row['town'],
                $row['postcode'],
                $row['street']
            );
        }

        return $companies;
    }
}
