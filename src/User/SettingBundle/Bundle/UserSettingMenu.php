<?php
namespace User\SettingBundle\Bundle;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class UserSettingMenu
{
    var $router = null;

    /**
     * UserSettingMenu constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');
    }

    /**
     * @param Menu $menu
     */
    public function inflateUserMenu(Menu $menu)
    {
        $main_menu = $menu->addMenu('users');
        $main_menu->setTitle('تنظیمات کاربری');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('group');
        $sub_menu_1->setTitle('بروزرسانی مشخصات');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($this->router->generate('user_setting_profile'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->setTags([
            'user_setting_profile'
        ]);

        $sub_menu_2 = $main_menu->addMenu('user');
        $sub_menu_2->setTitle('تغییر رمز عبور');
        $sub_menu_2->setSort(200);
        $sub_menu_2->setUrl($this->router->generate('user_setting_password'));
        $sub_menu_2->setIcon('circle-o');
        $sub_menu_2->setTags([
            'user_setting_password'
        ]);
    }
}