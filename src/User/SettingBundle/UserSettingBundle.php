<?php

namespace User\SettingBundle;

use AppBundle\Helper\Menu;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use User\SettingBundle\Bundle\UserSettingBreadcrumb;
use User\SettingBundle\Bundle\UserSettingMenu;

class UserSettingBundle extends Bundle
{
    /**
     * @return UserSettingBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new UserSettingBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateUserMenu(Menu $menu)
    {
        $user_menu = new UserSettingMenu($this->container);
        $user_menu->inflateUserMenu($menu);
    }
}
