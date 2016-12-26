<?php

namespace AppBundle\Command;

use AppBundle\Helper\App;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AppUpdatePasswordCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:update-password')
            ->setDescription('Update user password')
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');

        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $user = $em->getRepository('AppBundle:User')->findOneByEmail($email);

        $helper = $this->getHelper('question');
        $question = new Question('Please enter the password: ');
        $password = $helper->ask($input, $output, $question);

        $encoder = $this->getContainer()->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        $em->flush();

        $output->writeln("Password changed successfully.");
    }

}
