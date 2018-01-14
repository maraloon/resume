<?php

namespace App\Controller;

use App\Entity\Resume;
use Doctrine\Common\Persistence\ObjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    /**
     * @Route("/report", name="report")
     */
    public function report()
    {
        $bestResume = $this->getResumeRepo()->findMostPopular();

        $invites = $bestResume->getInvites();

        return $this->render('report/index.html.twig', [
            'resume' => $bestResume,
            'invites' => $invites
        ]);
    }

    private function getResumeRepo(): ObjectRepository
    {
        return $this->getDoctrine()->getManager()->getRepository(Resume::class);
    }
}
