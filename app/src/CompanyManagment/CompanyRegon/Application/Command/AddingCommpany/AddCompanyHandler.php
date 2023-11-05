<?php

declare(strict_types=1);

namespace CompanyManagment\CompanyRegon\Application\Command\AddingCommpany;

use RuntimeException;
use CompanyManagment\CompanyRegon\Domain\Company\Regon;
use CompanyManagment\CompanyRegon\Application\Command\Command;
use CompanyManagment\CompanyRegon\Application\Command\Handler;
use CompanyManagment\CompanyRegon\Domain\Company\AddCompanyService;
use CompanyManagment\CompanyRegon\Domain\Company\Exception\CouldNotAddCompany;

class AddCompanyHandler implements Handler
{
    public function __construct(private AddCompanyService $addCompanyService)
    {
    }

    public function __invoke(Command $command): void
    {
        $regon = Regon::create(
            $command->getRegon()
        );

        try {
            $this->addCompanyService->fetchAddCompany($regon);
        } catch (CouldNotAddCompany $couldNotAddCompany) {
            throw new RuntimeException($couldNotAddCompany->getMessage());
        }
    }
}
