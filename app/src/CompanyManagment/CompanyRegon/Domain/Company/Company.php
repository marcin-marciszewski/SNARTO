<?php

namespace CompanyManagment\CompanyRegon\Domain\Company;

use CompanyManagment\CompanyRegon\Domain\Company\CompanyId;

class Company
{
    private function __construct(
        private CompanyId $companyId,
        private ?string $regon,
        private ?string $name,
        private ?string $voivodeship,
        private ?string $county,
        private ?string $borough,
        private ?string $town,
        private ?string $postCode,
        private ?string $street
    ) {
    }

    public static function create(
        CompanyId $companyId,
        ?string $regon,
        ?string $name,
        ?string $voivodeship,
        ?string $county,
        ?string $borough,
        ?string $town,
        ?string $postCode,
        ?string $street
    ): self {
        return new self($companyId, $regon, $name, $voivodeship, $county, $borough, $town, $postCode, $street);
    }


    public function getId(): CompanyId
    {
        return $this->companyId;
    }

    public function getRegon(): ?string
    {
        return $this->regon;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getVoivodeship(): ?string
    {
        return $this->voivodeship;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function getBorough(): ?string
    {
        return $this->borough;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }
}
