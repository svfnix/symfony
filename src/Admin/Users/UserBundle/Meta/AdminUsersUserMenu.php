<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\UserBundle\Meta;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class AdminUsersUserMenu
{
    public function inflateAdminMenus(Menu $menu){

        $router = App::getInstance()->getRouter();

        $main_menu = $menu->addMenu('users');
        $main_menu->setTitle('مدیریت کاربران');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('user');
        $sub_menu_1->setTitle('مدیریت کاربران');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($router->generate('admin_users_user'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->addPermission('admin_users_user');
        $sub_menu_1->setTags([
            'admin_users_user',
            'admin_users_user_add',
            'admin_users_user_edit'
        ]);
    }
}