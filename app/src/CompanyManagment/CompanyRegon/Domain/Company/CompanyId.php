<?php

namespace CompanyManagment\CompanyRegon\Domain\Company;

use Ramsey\Uuid\Uuid;

class CompanyId
{
    private function __construct(private string $id)
    {
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $id): self
    {
        if (false === Uuid::isValid($id)) {
            throw new \DomainException(
                \sprintf("CompanyId '%s' is not valid", $id)
            );
        }

        return new self($id);
    }

    public function toString(): string
    {
        return $this->id;
    }
}
