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

        $section = $list->addPermissionGroup('users');
        $section->setTitle('مدیریت کاربران');
        $section->setSort(1000);



        $sub_section1 = $section->addPermissionGroup('users_user');
        $sub_section1->setTitle('مدیریت کاربران');
        $sub_section1->setSort(1000);

        $sub_section1->addPermission('admin_user_user', 'مشاهده لیست گروه های کاربری');
        $sub_section1->addPermission('admin_user_user_add', 'افزودن گروه کاربری جدید');
        $sub_section1->addPermission('admin_user_user_edit', 'ویرایش گروه کاربری');
        $sub_section1->addPermission('admin_user_user_delete', 'حذف گروه کاربری');



        $sub_section2 = $section->addPermissionGroup('users_group');
        $sub_section2->setTitle('مدیریت گروه های کاربری');
        $sub_section2->setSort(2000);

        $sub_section2->addPermission('admin_user_group', 'مشاهده لیست کاربران');
        $sub_section2->addPermission('admin_user_group_add', 'افزودن کاربر جدید');
        $sub_section2->addPermission('admin_user_group_edit', 'ویرایش کاربر');
        $sub_section2->addPermission('admin_user_group_delete', 'حذف کاربر');

    }
}