<?php

namespace Admin\Users\GroupBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminUsersGroupBundle extends Bundle
{
    public function inflateAdminMenu(Menu $menu, Router $router){

        $main_menu = $menu->addMenu('user_setting');
        $main_menu->setTitle('تنظیمات کاربری');
        $main_menu->setSort(1000);
        $main_menu->setIcon('user');

        $sub_menu_1 = $main_menu->addMenu('profile');
        $sub_menu_1->setTitle('مشخصات کاربری');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($router->generate('user_settings_profile'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->setLabel('99', Menu::GREEN);
        $sub_menu_1->setTag('user_settings_profile');


        $sub_menu_2 = $main_menu->addMenu('password');
        $sub_menu_2->setTitle('تغییر رمز عبور');
        $sub_menu_2->setSort(110);
        $sub_menu_2->setUrl($router->generate('user_settings_profile_other'));
        $sub_menu_2->setIcon('circle-o');
        $sub_menu_2->setTag('user_settings_profile_other');


        $sub_menu_3 = $main_menu->addMenu('home');
        $sub_menu_3->setTitle('صفحه اصلی');
        $sub_menu_3->setSort(0);
        $sub_menu_3->setUrl($router->generate('homepage'));
        $sub_menu_3->setIcon('circle-o');
        $sub_menu_3->setTag('homepage');
    }
}
