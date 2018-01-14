<?php

namespace App\Repository;

use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resume::class);
    }

    public function findMostPopular()
    {
        return $this->_em->createQuery('
            SELECT resume,COUNT(resume.id) AS invites
            FROM ' . Resume::class . ' resume
            INNER JOIN resume.companies c
            WHERE c.answer=TRUE
            GROUP BY resume.id
            ORDER BY invites DESC
        ')
            //todo it's a hack
            ->getResult()[0][0];
    }

}
