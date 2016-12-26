<?php

namespace Admin\Users\GroupBundle;

use Admin\Users\GroupBundle\Meta\AdminUsersGroupMenu;
use Admin\Users\GroupBundle\Meta\AdminUsersGroupBreadcrumb;
use Admin\Users\GroupBundle\Meta\AdminUsersGroupPermissions;
use AppBundle\Helper\Permission;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Helper\Menu;
use Symfony\Component\Routing\Router;

class AdminUsersGroupBundle extends Bundle
{
    /**
     * @return AdminUsersGroupBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new AdminUsersGroupBreadcrumb();
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenus(Menu $menu)
    {
        $admin_menu = new AdminUsersGroupMenu();
        $admin_menu->inflateAdminMenus($menu);
    }

    /**
     * @param Permission $permissions
     */
    public function inflateAdminPermissions(Permission $permissions)
    {
        $permission = new AdminUsersGroupPermissions();
        $permission->inflateAdminPermissions($permissions);
    }
}
