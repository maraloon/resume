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
        $qb = $this->_em->createQueryBuilder();

        $qb
            ->select('r')
            ->from('\App\Entity\Resume', 'r')
            ->innerJoin('r.companies', 'c')
            ->where('c.answer = :answer')
            ->groupBy('r.id')
            ->orderBy(
                $qb->expr()->count('r.id'),
                'DESC')
            ->setParameter('answer', true)
            ->setFirstResult(1)
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

}
