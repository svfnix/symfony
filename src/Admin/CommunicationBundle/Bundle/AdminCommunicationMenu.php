<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\CommunicationBundle\Bundle;


use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class AdminCommunicationMenu
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

        $main_menu = $menu->addMenu('communication');
        $main_menu->setTitle('مدیریت ارتباطات');
        $main_menu->setSort(1000);
        $main_menu->setIcon('envelope-o');

        $sub_menu_1 = $main_menu->addMenu('message');
        $sub_menu_1->setTitle('مدیریت پیام ها');
        $sub_menu_1->setSort(100);
        $sub_menu_1->setUrl($this->router->generate('admin_communication_message'));
        $sub_menu_1->setIcon('circle-o');
        $sub_menu_1->addPermission('admin_communication_message');
        $sub_menu_1->setTags([
            'admin_communication_message',
            'admin_communication_message_add',
            'admin_communication_message_edit'
        ]);
    }
}