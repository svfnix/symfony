<?php
namespace User\SettingBundle\Bundle;

use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbWrapper;

class UserSettingBreadcrumb extends BreadcrumbWrapper
{
    private $router = null;

    /**
     * UserSettingBreadcrumb constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');

        $this->base('تنظیمات کاربری');
    }

    /**
     * @return Breadcrumb
     */
    public function profileIndex()
    {
        return $this->add('بروزرسانی مشخصات', $this->router->generate('user_setting_profile'));
    }

    /**
     * @return Breadcrumb
     */
    public function passwordIndex()
    {
        return $this->add('تغییر رمز عبور', $this->router->generate('user_setting_password'));
    }
}