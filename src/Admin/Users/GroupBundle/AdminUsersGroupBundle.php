<?php

namespace Admin\Users\GroupBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Provider\Menu;
use Symfony\Component\Routing\Router;

class AdminUsersGroupBundle extends Bundle
{
    public function inflateAdminMenu(Menu $menu, Router $router){

        $main_menu = $menu->addMenu('users');
        $main_menu->setTitle('مدیریت کاربران');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('group');
        $sub_menu_1->setTitle('مدیریت گروه ها');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($router->generate('admin_users_group'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->setTag('admin_users_group');
    }
}
