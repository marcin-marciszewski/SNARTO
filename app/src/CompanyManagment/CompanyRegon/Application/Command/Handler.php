<?php

declare(strict_types=1);

namespace CompanyManagment\CompanyRegon\Application\Command;

interface Handler
{
    public function __invoke(Command $command): void;
}
