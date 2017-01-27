<?php

namespace User\CommunicationBundle;

use AppBundle\Helper\Menu;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use User\CommunicationBundle\Bundle\UserCommunicationBreadcrumb;
use User\CommunicationBundle\Bundle\UserCommunicationMenu;

class UserCommunicationBundle extends Bundle
{
    /**
     * @return UserCommunicationBreadcrumb
     */
    public function getBreadcrumb()
    {
        return new UserCommunicationBreadcrumb($this->container);
    }

    /**
     * @param Menu $menu
     */
    public function inflateUserMenu(Menu $menu)
    {
        $user_menu = new UserCommunicationMenu($this->container);
        $user_menu->inflateUserMenu($menu);
    }
}
