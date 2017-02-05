<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\NoticeBundle\Bundle;

use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbWrapper;
use Symfony\Component\Routing\Router;

class AdminNoticeBreadcrumb extends BreadcrumbWrapper
{
    var $router = null;

    /**
     * AdminNoticeBreadcrumb constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');
        $this->base('اطلاع رسانی');
    }

    /**
     * @return Breadcrumb
     */
    public function messageIndex()
    {
        return $this->add('مدیریت پیام ها', $this->router->generate('admin_notice_message'));
    }

    /**
     * @return Breadcrumb
     */
    public function messageAdd()
    {
        return $this->messageIndex()->add('ارسال پیام جدید');
    }

    /**
     * @return Breadcrumb
     */
    public function messageEdit()
    {
        return $this->messageIndex()->add('ویرایش پیام');
    }

    /**
     * @return Breadcrumb
     */
    public function notificationIndex()
    {
        return $this->add('مدیریت اطلاعیه ها', $this->router->generate('admin_notice_notification'));
    }

    /**
     * @return Breadcrumb
     */
    public function notificationAdd()
    {
        return $this->notificationIndex()->add('ارسال اطلاعیه جدید');
    }

    /**
     * @return Breadcrumb
     */
    public function notificationEdit()
    {
        return $this->notificationIndex()->add('ویرایش اطلاعیه');
    }

    /**
     * @return Breadcrumb
     */
    public function newsIndex()
    {
        return $this->add('مدیریت خبر ها', $this->router->generate('admin_notice_news'));
    }

    /**
     * @return Breadcrumb
     */
    public function newsAdd()
    {
        return $this->newsIndex()->add('ارسال خبر جدید');
    }

    /**
     * @return Breadcrumb
     */
    public function newsEdit()
    {
        return $this->newsIndex()->add('ویرایش خبر');
    }
}