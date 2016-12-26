<?php

namespace Admin\Users\UserBundle;

use Admin\Users\UserBundle\Meta\AdminUsersUserMenu;
use Admin\Users\UserBundle\Meta\AdminUsersUserBreadcrumb;
use Admin\Users\UserBundle\Meta\AdminUsersUserPermissions;
use AppBundle\Helper\Permission;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Helper\Menu;
use Symfony\Component\Routing\Router;

class AdminUsersUserBundle extends Bundle
{
    /**
     * @return AdminUsersUserBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new AdminUsersUserBreadcrumb();
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenus(Menu $menu)
    {
        $admin_menu = new AdminUsersUserMenu();
        $admin_menu->inflateAdminMenus($menu);
    }

    /**
     * @param Permission $permissions
     */
    public function inflateAdminPermissions(Permission $permissions)
    {
        $permission = new AdminUsersUserPermissions();
        $permission->inflateAdminPermissions($permissions);
    }
}
