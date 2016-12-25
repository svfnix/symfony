<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\GroupBundle\Meta;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class AdminUsersGroupMenu
{
    public function inflateAdminMenu(Menu $menu){

        $router = App::getInstance()->getRouter();

        $main_menu = $menu->addMenu('users');
        $main_menu->setTitle('مدیریت کاربران');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('group');
        $sub_menu_1->setTitle('مدیریت گروه ها');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($router->generate('admin_users_group'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->setTags([
            'admin_users_group',
            'admin_users_group_add',
            'admin_users_group_edit'
        ]);
    }
}