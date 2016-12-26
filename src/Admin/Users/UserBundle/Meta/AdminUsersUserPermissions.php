<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\UserBundle\Meta;

use AppBundle\Helper\Permission;

class AdminUsersUserPermissions
{
    public function inflateAdminPermissions(Permission $list){

        $section = $list->addPermissionGroup('users_user');
        $section->setTitle('مدیریت کاربران');
        $section->setSort(1000);

        $section->addPermission('admin_users_group', 'مشاهده لیست کاربران');
        $section->addPermission('admin_users_group_add', 'افزودن کاربر جدید');
        $section->addPermission('admin_users_group_edit', 'ویرایش کاربر');
        $section->addPermission('admin_users_group_delete', 'حذف کاربر');

    }
}