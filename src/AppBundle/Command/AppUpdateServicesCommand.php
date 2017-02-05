<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class AppUpdateServicesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:update-services')
            ->setDescription('dynamically link bundles services in config file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(str_repeat('=', 30));
        $output->writeln('start linking services ...');
        $output->writeln(str_repeat('-', 30));

        $kernel = $this->getContainer()->get('kernel');

        $root =  dirname($kernel->getRootDir());
        $bundles = $kernel->getBundles();

        $config = "{$root}/app/config/services_custom.yml";
        file_put_contents($config, "imports:");

        foreach ($bundles as $name => $bundle) {
            $path = $bundle->getPath();
            $path_array = explode('/', ltrim(substr($path, strlen($root)), '/'));

            if ($path_array[0] == 'src') {

                $output->writeln("- {$name} [{$path}]");

                $service_file = $kernel->locateResource("@{$name}/Resources/config/services.yml");
                if (file_exists($service_file)) {
                    file_put_contents(
                        $config,
                        "\n    - { resource: \"@{$name}/Resources/config/services.yml\" }",
                        FILE_APPEND
                    );
                }
            }
        }

        $output->writeln(str_repeat('-', 30));
        $output->writeln('finished.');
    }

}
