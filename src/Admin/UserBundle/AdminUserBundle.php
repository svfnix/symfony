<?php

namespace Admin\UserBundle;

use Admin\UserBundle\Bundle\AdminUserBreadcrumb;
use Admin\UserBundle\Bundle\AdminUserMenu;
use Admin\UserBundle\Bundle\AdminUserPermission;
use AppBundle\Helper\Menu;
use AppBundle\Helper\Permission;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminUserBundle extends Bundle
{
    /**
     * @return AdminUserBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new AdminUserBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenu(Menu $menu)
    {
        $admin_menu = new AdminUserMenu($this->container);
        $admin_menu->inflateAdminMenu($menu);
    }

    /**
     * @param Permission $permissions
     */
    public function inflateAdminPermission(Permission $permissions)
    {
        $permission = new AdminUserPermission();
        $permission->inflateAdminPermission($permissions);
    }
}
