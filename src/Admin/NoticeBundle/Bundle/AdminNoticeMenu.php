<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\NoticeBundle\Bundle;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class AdminNoticeMenu
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

        $main_menu = $menu->addMenu('notification');
        $main_menu->setTitle('اطلاع رسانی');
        $main_menu->setSort(1000);
        $main_menu->setIcon('envelope-o');

        $sub_menu_1 = $main_menu->addMenu('message');
        $sub_menu_1->setTitle('مدیریت پیام ها');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($this->router->generate('admin_notice_message'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->addPermission('admin_notice_message');
        $sub_menu_1->setTags([
            'admin_notice_message',
            'admin_notice_message_add',
            'admin_notice_message_edit'
        ]);

        $sub_menu_2 = $main_menu->addMenu('notification');
        $sub_menu_2->setTitle('مدیریت اطلاعیه ها');
        $sub_menu_2->setSort(200);
        $sub_menu_2->setUrl($this->router->generate('admin_notice_notification'));
        $sub_menu_2->setIcon('circle-o');
        $sub_menu_2->addPermission('admin_notice_notification');
        $sub_menu_2->setTags([
            'admin_notice_notification',
            'admin_notice_notification_add',
            'admin_notice_notification_edit'
        ]);

        $sub_menu_3 = $main_menu->addMenu('news');
        $sub_menu_3->setTitle('مدیریت خبر ها');
        $sub_menu_3->setSort(300);
        $sub_menu_3->setUrl($this->router->generate('admin_notice_news'));
        $sub_menu_3->setIcon('circle-o');
        $sub_menu_3->addPermission('admin_notice_news');
        $sub_menu_3->setTags([
            'admin_notice_news',
            'admin_notice_news_add',
            'admin_notice_news_edit'
        ]);
    }
}