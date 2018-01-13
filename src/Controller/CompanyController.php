<?php

namespace App\Controller;

use App\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/company", name="company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/", name="company_list")
     */
    public function list()
    {
        $companies = $this->getRepo()->findAll();

        return $this->render('company/list.html.twig', [
            'companies' => $companies
        ]);
    }

    private function getRepo()
    {
        return $this->getDoctrine()->getManager()->getRepository(Company::class);
    }
}
