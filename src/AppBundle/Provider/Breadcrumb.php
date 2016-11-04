<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 10:03 PM
 */

namespace AppBundle\Provider;


class Breadcrumb
{
    /**
     * @var BreadcrumbItem
     */
    protected $breadcrumb;

    /**
     * @return BreadcrumbItem
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * @param $title
     * @param null $link
     * @return BreadcrumbItem
     */
    function createBreadcrumb($title, $link = null)
    {
        $this->breadcrumb = new BreadcrumbItem($title, $link);

        return $this->breadcrumb;
    }
}