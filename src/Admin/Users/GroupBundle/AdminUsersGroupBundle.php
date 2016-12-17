<?php

namespace Admin\Users\GroupBundle;

use Admin\Users\GroupBundle\Meta\AdminUsersGroupMenu;
use Admin\Users\GroupBundle\Meta\AdminUsersGroupBreadcrumb;
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
    public function inflateAdminMenu(Menu $menu)
    {
        $admin_menu = new AdminUsersGroupMenu();
        $admin_menu->createAdminMenu($menu);
    }
}
