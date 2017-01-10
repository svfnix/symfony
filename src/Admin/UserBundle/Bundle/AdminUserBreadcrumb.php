<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\UserBundle\Bundle;

use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbWrapper;
use Symfony\Component\Routing\Router;

class AdminUserBreadcrumb extends BreadcrumbWrapper
{
    var $router = null;

    /**
     * AdminUsersGroupBreadcrumb constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');
        $this->base('مدیریت کاربران');
    }

    /**
     * @return Breadcrumb
     */
    public function groupIndex()
    {
        return $this->add('مدیریت گروه ها', $this->router->generate('admin_user_group'));
    }

    /**
     * @return Breadcrumb
     */
    public function groupAdd()
    {
        return $this->groupIndex()->add('افزودن عنوان جدید');
    }

    /**
     * @return Breadcrumb
     */
    public function groupEdit()
    {
        return $this->groupIndex()->add('ویرایش عنوان');
    }

    /**
     * @return Breadcrumb
     */
    public function userIndex()
    {
        return $this->add('مدیریت کاربران', $this->router->generate('admin_user_user'));
    }

    /**
     * @return Breadcrumb
     */
    public function userAdd()
    {
        return $this->userIndex()->add('افزودن عنوان جدید');
    }

    /**
     * @return Breadcrumb
     */
    public function userEdit()
    {
        return $this->userIndex()->add('ویرایش عنوان');
    }
}