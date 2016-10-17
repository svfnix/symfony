<?php

namespace AppBundle\Containers;

class Menu
{
    private $title;
    private $sort;
    private $url;
    private $icon;
    private $target;
    private $stack;

    /**
     * Menu constructor.
     */
    function __construct(){
        $this->sort = 0;
        $this->stack = [];
    }

    function addMenu($name) {

        $menu = new Menu();
        $this->stack[$name] = $menu;

        return $menu;
    }

    /**
     * @param $name
     * @return Menu
     */
    function getMenu($name){
        return $this->stack[$name];
    }

    /**
     * @param $name
     */
    function removeMenu($name){
        unset($this->stack[$name]);
    }

    /**
     * @return array
     */
    function getMenus(){
        usort($this->stack, function ($item1, $item2) {
            return $item1->getSort() <=> $item2->getSort();
        });

        return $this->stack;
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
     * @return Menu
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }
}