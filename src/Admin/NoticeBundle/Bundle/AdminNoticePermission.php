<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\NoticeBundle\Bundle;

use AppBundle\Helper\Permission;

class AdminNoticePermission
{
    public function inflateAdminPermission(Permission $list){

        $section = $list->addPermissionGroup('users_group');
        $section->setTitle('اطلاع رسانی');
        $section->setSort(1000);

        $section->addPermission('admin_notice_message', 'مشاهده لیست پیام ها');
        $section->addPermission('admin_notice_message_add', 'ارسال پیام جدید');
        $section->addPermission('admin_notice_message_edit', 'ویرایش پیام');
        $section->addPermission('admin_notice_message_delete', 'حذف پیام');

        $section->addPermission('admin_notice_notification', 'مشاهده لیست اطلاعیه ها');
        $section->addPermission('admin_notice_notification_add', 'ارسال اطلاعیه جدید');
        $section->addPermission('admin_notice_notification_edit', 'ویرایش اطلاعیه');
        $section->addPermission('admin_notice_notification_delete', 'حذف اطلاعیه');

        $section->addPermission('admin_notice_news', 'مشاهده لیست خبر ها');
        $section->addPermission('admin_notice_news_add', 'ارسال خبر جدید');
        $section->addPermission('admin_notice_news_edit', 'ویرایش خبر');
        $section->addPermission('admin_notice_news_delete', 'حذف خبر');

    }
}