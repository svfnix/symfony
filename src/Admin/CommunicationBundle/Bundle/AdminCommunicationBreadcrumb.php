<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:02 PM
 */

namespace Admin\CommunicationBundle\Bundle;

use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\BreadcrumbWrapper;
use Symfony\Component\Routing\Router;

class AdminCommunicationBreadcrumb extends BreadcrumbWrapper
{
    var $router = null;

    /**
     * AdminCommunicationBreadcrumb constructor.
     * @param $container
     */
    function __construct($container)
    {
        $this->router = $container->get('router');
        $this->base('مدیریت ارتباطات');
    }

    /**
     * @return Breadcrumb
     */
    public function messageIndex()
    {
        return $this->add('مدیریت پیام ها', $this->router->generate('admin_communication_message'));
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
        return $this->add('مدیریت اطلاعیه ها', $this->router->generate('admin_communication_notification'));
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
}