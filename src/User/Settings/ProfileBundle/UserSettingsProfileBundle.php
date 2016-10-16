<?php

namespace User\Settings\ProfileBundle;

use Knp\Menu\MenuFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserSettingsProfileBundle extends Bundle
{
    public function getUserMenu(MenuFactory $factory){

        $menu = $factory->createItem('My menu');
        $menu->addChild('Home', array('uri' => '/'));
        $menu->addChild('Comments', array('uri' => '#comments'));
        $menu->addChild('Symfony2', array('uri' => 'http://symfony-reloaded.org/'));
        $menu->addChild('Coming soon');

        return [
            'order' => 0,
            'title' => '',
            'menu' => $menu
        ];
    }
}
