<?php
namespace User\CommunicationBundle\Bundle;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class UserCommunicationMenu
{
    var $router = null;
    var $user = null;

    /**
     * UserSettingMenu constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');
        $this->user = $container->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @param Menu $menu
     */
    public function inflateUserMenu(Menu $menu)
    {
        $main_menu = $menu->addMenu('communication');
        $main_menu->setTitle('اطلاع رسانی و پشتیبانی');
        $main_menu->setSort(1000);
        $main_menu->setIcon('envelope-o');

        $sub_menu_1 = $main_menu->addMenu('message');
        $sub_menu_1->setTitle('پیام های دریافتی');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($this->router->generate('user_communication_message'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->setTags([
            'user_communication_message',
            'user_communication_message_read'
        ]);

        $message_count = $this->user->getMetaMessageCount();
        if($message_count){
            $sub_menu_1->setLabel($message_count, 'orange');
        }

        $sub_menu_2 = $main_menu->addMenu('notification');
        $sub_menu_2->setTitle('اطلاعیه های دریافتی');
        $sub_menu_2->setSort(200);
        $sub_menu_2->setUrl($this->router->generate('user_communication_notification'));
        $sub_menu_2->setIcon('circle-o');
        $sub_menu_2->setTags([
            'user_communication_notification'
        ]);

        $notification_count = $this->user->getMetaNotificationCount();
        if($notification_count){
            $sub_menu_2->setLabel($notification_count, 'orange');
        }
    }
}