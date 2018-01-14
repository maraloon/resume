<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/resume", name="resume")
 */
class ResumeController extends Controller
{
    /**
     * @Route("/add", name="_add")
     */
    public function add(Request $request)
    {
        $form = $this->createForm(ResumeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $resume = $form->getData();

            $this->getEm()->persist($resume);
            $this->getEm()->flush();

            $this->addFlash('success', 'Резюме добавлено!');
            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume/edit.html.twig', [
            'resumeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="_list")
     */
    public function list()
    {
        $resumes = $this->getRepo()->findAll();

        return $this->render('resume/list.html.twig', [
            'resumes' => $resumes
        ]);
    }

    /**
     * @Route("/{id}", name="_show")
     */
    public function show(Resume $resume)
    {
        $resume = $this->getRepo()->find($resume);

        return $this->render('resume/show.html.twig', [
            'resume' => $resume
        ]);
    }

    /**
     * @Route("/edit/{id}", name="_edit")
     */
    public function edit(Request $request, Resume $resume)
    {
        $form = $this->createForm(ResumeType::class, $resume);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->getEm()->persist($resume);
            $this->getEm()->flush();

            $this->addFlash('success', 'Резюме обновлено!');
            return $this->redirectToRoute('resume_list');

        }

        return $this->render('resume/edit.html.twig', [
            'resumeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_delete")
     */
    public function delete(Resume $resume)
    {
        $this->getEm()->remove($resume);
        $this->getEm()->flush();

        $this->addFlash('success', 'Резюме удалено!');
        return $this->redirectToRoute('resume_list');
    }

    private function getEm(): ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    private function getRepo(): ObjectRepository
    {
        return $this->getEm()->getRepository(Resume::class);
    }
}
