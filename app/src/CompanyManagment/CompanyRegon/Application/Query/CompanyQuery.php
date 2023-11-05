<?php

namespace CompanyManagment\CompanyRegon\Application\Query;

use CompanyManagment\CompanyRegon\Domain\Company\Company;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyRepository;

class CompanyQuery
{
    public function __construct(private CompanyRepository $repository)
    {
    }

    public function fetchAll(): array
    {
        $results = $this->repository->getAll();

        return \array_map(function (Company $item) {
            return new CompanyDTO(
                $item->getRegon(),
                $item->getName(),
                $item->getVoivodeship(),
                $item->getCounty(),
                $item->getBorough(),
                $item->getTown(),
                $item->getPostCode(),
                $item->getStreet(),
            );
        }, $results);
    }
}
