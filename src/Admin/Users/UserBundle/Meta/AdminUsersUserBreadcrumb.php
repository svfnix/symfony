<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\UserBundle\Meta;


use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbItem;
use AppBundle\Helper\App;
use Symfony\Component\Routing\Router;

class AdminUsersUserBreadcrumb extends Breadcrumb
{
    /**
     * AdminUsersGroupBreadcrumb constructor.
     */
    function __construct()
    {
        $this->breadcrumb = $this->createBreadcrumb('مدیریت کاربران');
    }

    /**
     * @return BreadcrumbItem
     */
    public function actionDefault()
    {
        $router = App::getInstance()->getRouter();
        $this->breadcrumb = $this->getBreadcrumb()->add('مدیریت کاربران', $router->generate('admin_users_user'));
        return $this->breadcrumb;
    }

    /**
     * @return BreadcrumbItem
     */
    public function actionAdd()
    {
        $this->breadcrumb = $this->actionDefault()->add('افزودن عنوان جدید');
        return $this->breadcrumb;
    }

    /**
     * @return BreadcrumbItem
     */
    public function actionEdit()
    {
        $this->breadcrumb = $this->actionDefault()->add('ویرایش عنوان');
        return $this->breadcrumb;
    }
}