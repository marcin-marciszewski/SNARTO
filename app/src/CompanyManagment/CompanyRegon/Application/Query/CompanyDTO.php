<?php

namespace CompanyManagment\CompanyRegon\Application\Query;

class CompanyDTO
{
    public function __construct(
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
