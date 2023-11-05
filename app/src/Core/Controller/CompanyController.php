<?php

namespace App\Core\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use CompanyManagment\CompanyRegon\Application\Query\CompanyQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use CompanyManagment\CompanyRegon\Application\Command\AddingCommpany\AddCompanyCommand;

#[Route('/', name: 'api_')]
class CompanyController extends AbstractController
{
    #[Route('/api/regon', name: 'company_index', methods: ['get'],)]
    public function index(CompanyQuery $companyList): Response
    {
        $companies = $companyList->fetchAll();

        return $this->json($companies);
    }

    #[Route('/api/regon', name: 'company_create', methods: ['post'],)]
    public function create(Request $request, MessageBusInterface $messageBus): Response
    {
        $regon = json_decode($request->getContent())->regon ?? null;
        if ($regon) {
            $command = new AddCompanyCommand($regon);
            $messageBus->dispatch($command);
            return $this->json(['succes' => 'Company added successfully.'], 200);
        }

        return $this->json(['error' => 'Something went wrong.'], 500);
    }
}
