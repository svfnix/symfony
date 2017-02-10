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

        $section = $list->addPermissionGroup('notice');
        $section->setTitle('اطلاع رسانی');
        $section->setSort(1000);


        $sub_section1 = $section->addPermissionGroup('notice_message');
        $sub_section1->setTitle('مدیریت پیام ها');
        $sub_section1->setSort(1000);

        $sub_section1->addPermission('admin_notice_message', 'مشاهده لیست پیام ها');
        $sub_section1->addPermission('admin_notice_message_add', 'ارسال پیام جدید');
        $sub_section1->addPermission('admin_notice_message_edit', 'ویرایش پیام');
        $sub_section1->addPermission('admin_notice_message_delete', 'حذف پیام');


        $sub_section2 = $section->addPermissionGroup('notice_notification');
        $sub_section2->setTitle('مدیریت اطلاعیه ها');
        $sub_section2->setSort(2000);

        $sub_section2->addPermission('admin_notice_notification', 'مشاهده لیست اطلاعیه ها');
        $sub_section2->addPermission('admin_notice_notification_add', 'ارسال اطلاعیه جدید');
        $sub_section2->addPermission('admin_notice_notification_edit', 'ویرایش اطلاعیه');
        $sub_section2->addPermission('admin_notice_notification_delete', 'حذف اطلاعیه');


        $sub_section3 = $section->addPermissionGroup('notice_news');
        $sub_section3->setTitle('مدیریت خبر ها');
        $sub_section3->setSort(2000);

        $sub_section3->addPermission('admin_notice_news', 'مشاهده لیست خبر ها');
        $sub_section3->addPermission('admin_notice_news_add', 'ارسال خبر جدید');
        $sub_section3->addPermission('admin_notice_news_edit', 'ویرایش خبر');
        $sub_section3->addPermission('admin_notice_news_delete', 'حذف خبر');

    }
}