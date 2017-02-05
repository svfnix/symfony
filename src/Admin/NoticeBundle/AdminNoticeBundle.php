<?php

namespace Admin\NoticeBundle;

use Admin\NoticeBundle\Bundle\AdminNoticeBreadcrumb;
use Admin\NoticeBundle\Bundle\AdminNoticeMenu;
use Admin\NoticeBundle\Bundle\AdminNoticePermission;
use AppBundle\Helper\Menu;
use AppBundle\Helper\Permission;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AdminNoticeBundle extends Bundle
{
    /**
     * @return AdminNoticeBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new AdminNoticeBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateAdminMenu(Menu $menu)
    {
        $admin_menu = new AdminNoticeMenu($this->container);
        $admin_menu->inflateAdminMenu($menu);
    }

    /**
     * @param Permission $permissions
     */
    public function inflateAdminPermission(Permission $permissions)
    {
        $permission = new AdminNoticePermission();
        $permission->inflateAdminPermission($permissions);
    }
}
