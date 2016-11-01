<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 10:03 PM
 */

namespace AppBundle\Provider;


class BreadCrumb
{
    /**
     * @var BreadCrumbItem
     */
    protected $breadcrumb;

    /**
     * @return BreadCrumbItem
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * @param $title
     * @param null $link
     * @return BreadCrumbItem
     */
    function base($title, $link = null)
    {
        $this->breadcrumb = new BreadCrumbItem($title, $link);

        return $this->breadcrumb;
    }
}