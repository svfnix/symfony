<?php

namespace Admin\Users\GroupBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Provider\Menu;
use Symfony\Component\Routing\Router;

class AdminUsersGroupBundle extends Bundle
{
    public function getBreadCrumb(){
        return new AdminUsersGroupBreadCrumb();
    }

    public function inflateAdminMenu(Menu $menu, Router $router){

        $menu = new AdminUsersGroupAdminMenu();
        $menu->createAdminMenu($menu, $router);
    }
}
