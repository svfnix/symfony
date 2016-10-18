<?php
namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UseMenuExtension extends \Twig_Extension
{

    private $container;

    public function __construct(ContainerInterface $_container)
    {
        $this->container = $_container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('UserMenu', array($this, 'UserMenu')),
        );
    }

    public function UserMenu()
    {

    }

    public function getName()
    {
        return 'user_menu_extension';
    }
}