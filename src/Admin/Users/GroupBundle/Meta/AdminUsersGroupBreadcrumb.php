<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\GroupBundle\Meta;


use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbItem;
use AppBundle\Helper\App;
use Symfony\Component\Routing\Router;

class AdminUsersGroupBreadcrumb extends Breadcrumb
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
        $this->breadcrumb = $this->getBreadcrumb()->add('مدیریت گروه ها', $router->generate('admin_users_group'));
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