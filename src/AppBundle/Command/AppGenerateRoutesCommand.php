<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppGenerateRoutesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:generate_routes')
            ->setDescription('dynamically map bundles to routes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('start generating routes ...');

        $kernel = $this->createKernel();
        $kernel->boot();
        $bundles = $kernel->getBundles();

        foreach ($bundles as $bundle){
            $output->writeln($bundle);
        }



        $output->writeln('ok');
        $output->writeln('ok');
        $output->writeln('ok');
    }

}
