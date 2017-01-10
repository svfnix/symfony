<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class AppGenerateRoutesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:generate-routes')
            ->setDescription('dynamically map bundles to routes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(str_repeat('=', 30));
        $output->writeln('start generating routes ...');
        $output->writeln(str_repeat('-', 30));

        $kernel = $this->getContainer()->get('kernel');

        $root =  dirname($kernel->getRootDir());
        $bundles = $kernel->getBundles();

        $config = "{$root}/app/config/routing.yml";
        file_put_contents($config, "src:\n  resource: routing_custom.yml\n\n");

        foreach ($bundles as $name => $bundle) {
            if ($name != 'AppBundle') {

                $path = $bundle->getPath();
                $path_array = explode('/', ltrim(substr($path, strlen($root)), '/'));

                if ($path_array[0] == 'src') {

                    $output->writeln("- {$name} [{$path}]");

                    $finder = new Finder();
                    $finder
                        ->files()
                        ->in($kernel->locateResource("@{$name}/Controller/"))
                        ->name('*.php');

                    $bundle_route_config = $kernel->locateResource("@{$name}/Resources/config/routing.yml");
                    file_put_contents($bundle_route_config, '');

                    $name_array = explode('/', dirname(strtolower(preg_replace('/[A-Z]/', '/$0', $name))));
                    foreach ($finder as $file) {

                        $controller = basename($file->getBasename('Controller.php'));

                        $output->writeln("* ({$controller})");

                        $route = array_merge($name_array, [strtolower($controller)]);
                        file_put_contents(
                            $bundle_route_config,
                            implode('_', $route) . ":\n    resource: \"@{$name}/Controller/{$controller}Controller.php\"\n    type: annotation\n    prefix: " . implode('/', $route) . "\n\n",
                            FILE_APPEND);

                    }

                    file_put_contents(
                        $config,
                        "{$name}:\n  resource: \"@{$name}/Resources/config/routing.yml\"\n\n",
                        FILE_APPEND);
                }
            }
        }

        $output->writeln(str_repeat('-', 30));
        $output->writeln('finished.');
    }

}
