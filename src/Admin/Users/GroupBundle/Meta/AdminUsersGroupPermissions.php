<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\Users\GroupBundle\Meta;

use AppBundle\Helper\Permission;

class AdminUsersGroupPermissions
{
    public function inflateAdminPermissions(Permission $list){

        $section = $list->addPermissionGroup('users_group');
        $section->setTitle('مدیریت گروه های کاربری');
        $section->setSort(1000);

        $section->addPermission('admin_users_user', 'مشاهده لیست گروه های کاربری');
        $section->addPermission('admin_users_user_add', 'افزودن گروه کاربری جدید');
        $section->addPermission('admin_users_user_edit', 'ویرایش گروه کاربری');
        $section->addPermission('admin_users_user_delete', 'حذف گروه کاربری');

    }
}