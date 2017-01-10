<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\UserBundle\Bundle;

use AppBundle\Helper\Permission;

class AdminUserPermission
{
    public function inflateAdminPermission(Permission $list){

        $section = $list->addPermissionGroup('users_group');
        $section->setTitle('مدیریت کاربران');
        $section->setSort(1000);

        $section->addPermission('admin_user_user', 'مشاهده لیست گروه های کاربری');
        $section->addPermission('admin_user_user_add', 'افزودن گروه کاربری جدید');
        $section->addPermission('admin_user_user_edit', 'ویرایش گروه کاربری');
        $section->addPermission('admin_user_user_delete', 'حذف گروه کاربری');

        $section->addPermission('admin_user_group', 'مشاهده لیست کاربران');
        $section->addPermission('admin_user_group_add', 'افزودن کاربر جدید');
        $section->addPermission('admin_user_group_edit', 'ویرایش کاربر');
        $section->addPermission('admin_user_group_delete', 'حذف کاربر');

    }
}