<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\GroupBundle;


use AppBundle\Provider\BreadCrumb;
use AppBundle\Provider\BreadCrumbItem;

class AdminUsersGroupBreadCrumb extends BreadCrumb
{

    /**
     * @return BreadCrumbItem
     */
    function actionDefault()
    {
        $this->breadcrumb = $this->base('مدیریت کاربران')->add('مدیریت گروه ها', route('admin_users_group'));
        return $this->breadcrumb;
    }

    /**
     * @return BreadCrumbItem
     */
    function actionAdd()
    {
        $this->breadcrumb = $this->actionDefault()->add('افزودن عنوان جدید');
        return $this->breadcrumb;
    }

    /**
     * @return BreadCrumbItem
     */
    function actionEdit()
    {
        $this->breadcrumb = $this->actionDefault()->add('ویرایش عنوان');
        return $this->breadcrumb;
    }
}