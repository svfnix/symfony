<?php

namespace User\Settings\ProfileBundle;

use AppBundle\Containers\Menu;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserSettingsProfileBundle extends Bundle
{
    public function inflateUserMenu(Menu $menu){

        $main_menu = $menu->addMenu('user_setting');
        $main_menu->setTitle('تنظیمات کاربری');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('profile');
        $sub_menu_1->setTitle('مشخصات کاربری');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl('user_setting_profile');
        $sub_menu_1->setIcon('circle-o');

        $sub_menu_2 = $main_menu->addMenu('password');
        $sub_menu_2->setTitle('تغییر رمز عبور');
        $sub_menu_2->setSort(110);
        $sub_menu_2->setUrl('user_setting_password');
        $sub_menu_2->setIcon('circle-o');
    }
}
