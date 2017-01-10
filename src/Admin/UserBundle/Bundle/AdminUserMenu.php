<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\UserBundle\Bundle;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class AdminUserMenu
{
    var $router = null;

    /**
     * AdminUserMenu constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenu(Menu $menu)
    {

        $main_menu = $menu->addMenu('users');
        $main_menu->setTitle('مدیریت کاربران');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('group');
        $sub_menu_1->setTitle('مدیریت گروه ها');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($this->router->generate('admin_user_group'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->addPermission('admin_user_group');
        $sub_menu_1->setTags([
            'admin_user_group',
            'admin_user_group_add',
            'admin_user_group_edit'
        ]);

        $sub_menu_2 = $main_menu->addMenu('user');
        $sub_menu_2->setTitle('مدیریت کاربران');
        $sub_menu_2->setSort(200);
        $sub_menu_2->setUrl($this->router->generate('admin_user_user'));
        $sub_menu_2->setIcon('circle-o');
        $sub_menu_2->addPermission('admin_user_user');
        $sub_menu_2->setTags([
            'admin_user_user',
            'admin_user_user_add',
            'admin_user_user_edit'
        ]);
    }
}