<?php

namespace Admin\CommunicationBundle;

use Admin\CommunicationBundle\Bundle\AdminCommunicationBreadcrumb;
use Admin\CommunicationBundle\Bundle\AdminCommunicationMenu;
use Admin\CommunicationBundle\Bundle\AdminCommunicationPermission;
use AppBundle\Helper\Menu;
use AppBundle\Helper\Permission;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminCommunicationBundle extends Bundle
{
    /**
     * @return AdminCommunicationBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new AdminCommunicationBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenu(Menu $menu)
    {
        $admin_menu = new AdminCommunicationMenu($this->container);
        $admin_menu->inflateAdminMenu($menu);
    }

    /**
     * @param Permission $permissions
     */
    public function inflateAdminPermission(Permission $permissions)
    {
        $permission = new AdminCommunicationPermission();
        $permission->inflateAdminPermission($permissions);
    }
}
