<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\GroupBundle\Meta;


use AppBundle\Helper\AccessList;
use AppBundle\Helper\Menu;
use AppBundle\Helper\App;

class AdminUsersGroupAccessList
{
    public function inflateAdminMenu(AccessList $list){

        $section = $list->addAccessGroup('users_user');
        $section->setTitle('مدیریت کاربران');
        $section->setSort(1000);

        $section->addAccess('admin_users_group', 'مشاهده لیست کاربران');
        $section->addAccess('admin_users_group_add', 'افزودن کاربر جدید');
        $section->addAccess('admin_users_group_edit', 'ویرایش کاربر');
        $section->addAccess('admin_users_group_delete', 'حذف کاربر');

    }
}