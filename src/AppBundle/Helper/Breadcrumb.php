<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 10:03 PM
 */

namespace AppBundle\Helper;


class Breadcrumb
{
    /**
     * @var BreadcrumbItem
     */
    protected $head;

    /**
     * Breadcrumb constructor.
     * @param $title
     * @param null $link
     */
    function __construct($title, $link = null)
    {
        $this->head =  new BreadcrumbItem($title, $link);
        return $this;
    }

    /**
     * @param $title
     * @param null $link
     * @return $this
     */
    public function add($title, $link = null){
        $next = new BreadcrumbItem($title, $link);
        $next->setParent($this->head);
        $this->head = $next;

        return $this;
    }

    /**
     * @return BreadcrumbItem
     */
    public function getHead()
    {
        return $this->head;
    }
}