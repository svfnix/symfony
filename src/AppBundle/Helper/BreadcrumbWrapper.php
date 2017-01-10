<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 10:03 PM
 */

namespace AppBundle\Helper;


class BreadcrumbWrapper
{

    /**
     * @var Breadcrumb
     */
    protected $breadcrumb;

    /**
     * @return BreadcrumbItem
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb->getHead();
    }

    /**
     * @param $title
     */
    protected function base($title)
    {
        $this->breadcrumb = new Breadcrumb($title);
    }

    /**
     * @param $title
     * @param $link
     * @return Breadcrumb
     */
    protected function add($title, $link = null)
    {
        return $this->breadcrumb->add($title, $link);
    }
}