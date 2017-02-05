<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class AppBuildCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:build')
            ->setDescription('run all build scripts')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(str_repeat('=', 30));
        $output->writeln('start running build scripts ...');
        $output->writeln(str_repeat('-', 30));

        foreach ([
            'app:update-services',
            'app:update-routes'
                ] as $command){

            $output->writeln("\ncmd: {$command}");
            $command = $this->getApplication()->find($command);
            $cmd_input = new ArrayInput([]);
            $command->run($cmd_input, $output);
        }

        $output->writeln(str_repeat('-', 30));
        $output->writeln('finished.');
    }

}
