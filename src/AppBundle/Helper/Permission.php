<?php

namespace AppBundle\Helper;

class Permission
{

    private $priority;
    private $parent;

    private $title;
    private $sort;
    private $stack = [];
    private $permissions = [];

    /**
     * Menu constructor.
     * @param $_priority
     */
    function __construct($_priority=0){
        $this->priority = $_priority;
        $this->sort = 0;
        $this->stack = [];
        $this->permissions = [];
    }

    /**
     * @param $name
     * @param $_priority
     * @return Permission|mixed
     */
    function addPermissionGroup($name, $_priority=0) {

        if(isset($this->stack[$name])){
            if($this->stack[$name]->getPriority() >= $_priority){
                return $this->stack[$name];
            }
            $list = new Permission($_priority);
            $list->setStack($this->stack[$name]->getStack());
        } else {
            $list = new Permission($_priority);
        }

        $list->setParent($this);
        $this->stack[$name] = $list;

        return $list;
    }

    /**
     * @param $name
     * @return Permission
     */
    function getPermissionGroup($name){
        return $this->stack[$name];
    }

    /**
     * @param $name
     */
    function removePermissionGroup($name){
        unset($this->stack[$name]);
    }

    /**
     * @return array
     */
    function getPermissionGroups(){
        usort($this->stack, function ($item1, $item2) {
            return $item1->getSort() <=> $item2->getSort();
        });

        return $this->stack;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
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

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
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
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @param array $stack
     * @return $this
     */
    public function setStack(array $stack)
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param $name
     * @param $title
     * @return $this
     */
    public function addPermission($name, $title)
    {
        $this->permissions[$name] = $title;

        return $this;
    }

    /**
     * @param array $permissions
     * @return $this
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }
}