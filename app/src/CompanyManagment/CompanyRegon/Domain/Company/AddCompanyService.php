<?php

namespace CompanyManagment\CompanyRegon\Domain\Company;

use CompanyManagment\CompanyRegon\Domain\Company\Regon;
use CompanyManagment\CompanyRegon\Domain\Company\Company;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyId;
use CompanyManagment\CompanyRegon\Domain\Company\CompanyRepository;
use CompanyManagment\CompanyRegon\Domain\Company\Exception\CouldNotAddCompany;

class AddCompanyService
{
    private $loginTestUrl = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/Zaloguj';
    private $searchDataTestUrl = 'https://wyszukiwarkaregontest.stat.gov.pl/wsBIR/UslugaBIRzewnPubl.svc/ajaxEndpoint/daneSzukaj';
    private $key = "abcde12345abcde12345";
    private $session = null;

    public function __construct(private CompanyRepository $companyRepository)
    {
    }

    public function fetchAddCompany(Regon $regon): void
    {
        $companyDetails = $this->fetchByRegon($regon->getRegon());

        if (!isset($companyDetails->dane)) {
            throw new CouldNotAddCompany("Company details not found.");
        }

        $company = Company::create(
            CompanyId::generate(),
            (string)$companyDetails->dane->RegonLink->a ?? null,
            (string)$companyDetails->dane->Nazwa ?? null,
            (string)$companyDetails->dane->Wojewodztwo ?? null,
            (string)$companyDetails->dane->Powiat ?? null,
            (string)$companyDetails->dane->Gmina ?? null,
            (string)$companyDetails->dane->Miejscowosc ?? null,
            (string)$companyDetails->dane->KodPocztowy ?? null,
            (string)$companyDetails->dane->Ulica ?? null,
        );

        $this->companyRepository->store($company);
    }

    private function makeCurl($field, $url): mixed
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $field);
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($field), 'sid:' . $this->session]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36');
        curl_setopt($curl, CURLOPT_HEADER, false);
        $result = curl_exec($curl);
        curl_close($curl);

        if ($this->session == null) {
            return json_decode($result)->d;
        } else {
            $jsonString = str_replace('\u000d\u000a', '', $result);
            $jsonArray = json_decode($jsonString, true);
            $xmlString = html_entity_decode($jsonArray['d']);
            $xmlString = str_replace(array("\\/", '\\"'), array("/", '"'), $xmlString);

            return simplexml_load_string($xmlString);
        }
    }

    private function login(): mixed
    {
        $login = json_encode(["pKluczUzytkownika" => $this->key]);
        $result = $this->makeCurl($login, $this->loginTestUrl);
        return $result;
    }

    private function fetchByRegon($regon): mixed
    {
        if ($this->session == null) {
            $this->session = $this->login();
        }

        $searchData = json_encode(
            [
                'jestWojPowGmnMiej' => true,
                'pParametryWyszukiwania' => [
                    'AdsSymbolGminy' => null,
                    'AdsSymbolMiejscowosci' => null,
                    'AdsSymbolPowiatu' => null,
                    'AdsSymbolUlicy' => null,
                    'AdsSymbolWojewodztwa' => null,
                    'Dzialalnosci' => null,
                    'FormaPrawna' => null,
                    'Krs' => null,
                    'Krsy' => null,
                    'NazwaPodmiotu' => null,
                    'Nip' => null,
                    'Nipy' => null,
                    'NumerwRejestrzeLubEwidencji' => null,
                    'OrganRejestrowy' => null,
                    'PrzewazajacePKD' => false,
                    'Regon' => $regon,
                    'Regony14zn' => null,
                    'Regony9zn' => null,
                    'RodzajRejestru' => null,
                ]
            ]
        );

        return $this->makeCurl($searchData, $this->searchDataTestUrl);
    }
}
