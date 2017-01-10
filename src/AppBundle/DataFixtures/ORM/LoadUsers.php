<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use AppBundle\Helper\App;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {

        $user = new User();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        $user
            ->setUsername('user')
            ->setEmail('user@domain.tld')
            ->setPassword($encoder->encodePassword($user, 'passwd'));

        $manager->persist($user);

        $admin = new User();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        $admin
            ->setUsername('admin')
            ->setEmail('admin@domain.tld')
            ->setPassword($encoder->encodePassword($admin, 'passwd'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}