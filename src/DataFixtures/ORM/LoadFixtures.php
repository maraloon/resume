<?php


namespace App\DataFixtures\ORM;


use App\Entity\Company;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(__DIR__.'/fixtures.yaml', $manager);
//        $company = new Company();
//        $company->setName('Apple');
//
//        $manager->persist($company);
//        $manager->flush();
    }

}