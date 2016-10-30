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
            ->setName('app:generate:routes')
            ->setDescription('dynamically map bundles to routes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('start generating routes ...');

        $kernel = $this->getContainer()->get('kernel');

        $root =  dirname($kernel->getRootDir());
        $bundles = $kernel->getBundles();

        $config = "{$root}/app/config/routing_custom.yml";
        file_put_contents($config, '');
        foreach ($bundles as $name => $bundle){
            if($name != 'AppBundle') {
                $path = $bundle->getPath();
                $path = explode('/', ltrim(substr($path, strlen($root)), '/'));
                if ($path[0] == 'src') {
                    $output->writeln("- {$name} [".implode('/', $path)."]");
                    $path = explode('/', dirname(strtolower(preg_replace('/[A-Z]/', '/$0', $name))));
                    file_put_contents(
                        $config,
                        implode('_', $path).":\n  resource: \"@{$name}/Controller/\"\n  type: annotation\n  prefix: ".implode('/', $path)."\n\n",
                        FILE_APPEND);
                }
            }
        }

        $output->writeln('finished.');
    }

}
