<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class AppUpdateListenersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:update-listeners')
            ->setDescription('integrate event listeners to app services file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(str_repeat('=', 30));
        $output->writeln('start updating listeners ...');
        $output->writeln(str_repeat('-', 30));

        $kernel = $this->getContainer()->get('kernel');

        $finder = new Finder();
        $finder
            ->files()
            ->in($kernel->locateResource("@AppBundle/Resources/listeners/"))
            ->name('*.yml');

        $root =  dirname($kernel->getRootDir());
        $config = "{$root}/app/config/listeners.yml";

        file_put_contents($config, "imports:");
        foreach ($finder as $file) {

            $output->writeln('- ' . $file->getBasename());
            file_put_contents(
                $config,
                "\n    - { resource: \"@AppBundle/Resources/listeners/{$file->getBasename()}\" }",
                FILE_APPEND
            );
        }

        $output->writeln(str_repeat('-', 30));
        $output->writeln('finished.');
    }

}
