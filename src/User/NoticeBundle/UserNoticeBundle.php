<?php

namespace User\NoticeBundle;

use AppBundle\Helper\Menu;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use User\NoticeBundle\Bundle\UserNoticeBreadcrumb;
use User\NoticeBundle\Bundle\UserNoticeMenu;

class UserNoticeBundle extends Bundle
{
    /**
     * @return UserNoticeBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new UserNoticeBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateUserMenu(Menu $menu)
    {
        $user_menu = new UserNoticeMenu($this->container);
        $user_menu->inflateUserMenu($menu);
    }
}
