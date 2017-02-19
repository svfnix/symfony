<?php

namespace Admin\UserManagementBundle;

use Admin\UserManagementBundle\Bundle\AdminUserManagementBreadcrumb;
use Admin\UserManagementBundle\Bundle\AdminUserManagementMenu;
use Admin\UserManagementBundle\Bundle\AdminUserManagementPermission;
use AppBundle\Helper\Menu;
use AppBundle\Helper\Permission;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminUserManagementBundle extends Bundle
{
    /**
     * @return AdminUserManagementBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new AdminUserManagementBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenu(Menu $menu)
    {
        $admin_menu = new AdminUserManagementMenu($this->container);
        $admin_menu->inflateAdminMenu($menu);
    }

    /**
     * @param Permission $permissions
     */
    public function inflateAdminPermission(Permission $permissions)
    {
        $permission = new AdminUserManagementPermission();
        $permission->inflateAdminPermission($permissions);
    }
}
