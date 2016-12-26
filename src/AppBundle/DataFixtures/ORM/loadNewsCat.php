<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use News\CategoryBundle\Entity\Cat;

class LoadNewsCat implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=1000; $i++) {
            $cat = new Cat();
            $cat->setTitle("title {$i}");
            $cat->setName("name_{$i}");

            $manager->persist($cat);
            $manager->flush();
        }
    }
}
