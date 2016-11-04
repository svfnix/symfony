<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 11/1/16
 * Time: 9:03 PM
 */

namespace AppBundle\Provider;


class BreadcrumbItem
{
    private $title;
    private $link;
    private $parent;

    function __construct($title, $link=null)
    {
        $this->title = $title;
        $this->link = $link;
        $this->parent = null;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function add($title, $link=null){
        $next = new BreadcrumbItem($title, $link);
        $next->setParent($this);

        return $next;
    }
}