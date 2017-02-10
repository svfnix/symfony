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
        $user->generateSalt();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user
            ->setUsername('user')
            ->setEmail('user@domain.tld')
            ->setPassword($encoder->encodePassword('passwd', $user->getSalt()))
            ->setRole('ROLE_USER');
        $manager->persist($user);

        $admin = new User();
        $admin->generateSalt();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $admin
            ->setUsername('admin')
            ->setEmail('admin@domain.tld')
            ->setPassword($encoder->encodePassword('passwd', $user->getSalt()))
            ->setRole('ROLE_ADMIN');
        $manager->persist($admin);

        $super_admin = new User();
        $super_admin->generateSalt();
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($super_admin);
        $super_admin
            ->setUsername('super_admin')
            ->setEmail('super_admin@domain.tld')
            ->setPassword($encoder->encodePassword('passwd', $super_admin->getSalt()))
            ->setRole('ROLE_SUPER_ADMIN');
        $manager->persist($super_admin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}