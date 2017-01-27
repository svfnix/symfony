<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\CommunicationBundle\Bundle;

use AppBundle\Helper\Permission;

class AdminCommunicationPermission
{
    public function inflateAdminPermission(Permission $list){

        $section = $list->addPermissionGroup('users_group');
        $section->setTitle('مدیریت ارتباطات');
        $section->setSort(1000);

        $section->addPermission('admin_communication_message', 'مشاهده لیست پیام ها');
        $section->addPermission('admin_communication_message_add', 'ارسال پیام جدید');
        $section->addPermission('admin_communication_message_edit', 'ویرایش پیام');
        $section->addPermission('admin_communication_message_delete', 'حذف پیام');

        $section->addPermission('admin_communication_notification', 'مشاهده لیست اطلاعیه ها');
        $section->addPermission('admin_communication_notification_add', 'ارسال اطلاعیه جدید');
        $section->addPermission('admin_communication_notification_edit', 'ویرایش اطلاعیه');
        $section->addPermission('admin_communication_notification_delete', 'حذف اطلاعیه');

    }
}