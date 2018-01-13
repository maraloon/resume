<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/company", name="company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request)
    {
        $form = $this->createForm(CompanyType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $company = $form->getData();

            $this->getEm()->persist($company);
            $this->getEm()->flush();

            $this->addFlash('success', 'Компания добавлена!');
            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/edit.html.twig', [
            'companyForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="_list")
     */
    public function list()
    {
        $companies = $this->getRepo()->findAll();

        return $this->render('company/list.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/{id}", name="_show")
     */
    public function show(Company $company)
    {
        $company = $this->getRepo()->find($company);

        return $this->render('company/show.html.twig', [
            'company' => $company
        ]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     */
    public function edit(Request $request, Company $company)
    {
        $form = $this->createForm(CompanyType::class, $company);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->getEm()->persist($company);
            $this->getEm()->flush();

            $this->addFlash('success', 'Компания обновлена!');
            return $this->redirectToRoute('company_list');

        }

        return $this->render('company/edit.html.twig', [
            'companyForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete")
     */
    public function delete(Company $company)
    {
        $this->getEm()->remove($company);
        $this->getEm()->flush();

        $this->addFlash('success', 'Компания удалена!');
        return $this->redirectToRoute('company_list');
    }

    private function getEm(): ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    private function getRepo(): ObjectRepository
    {
        return $this->getEm()->getRepository(Company::class);
    }
}
