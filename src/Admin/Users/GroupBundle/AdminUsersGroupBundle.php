<?php

namespace Admin\Users\GroupBundle;

use Admin\Users\GroupBundle\Bundle\AdminUsersGroupMenu;
use Admin\Users\GroupBundle\Bundle\AdminUsersGroupBreadcrumb;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use AppBundle\Provider\Menu;
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
    public function inflateAdminMenu(Menu $menu)
    {
        $admin_menu = new AdminUsersGroupMenu();
        $admin_menu->createAdminMenu($menu);
    }
}
