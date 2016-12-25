<?php

namespace AppBundle\Helper;

class AccessList
{

    private $priority;
    private $parent;

    private $title;
    private $name;
    private $sort;
    private $stack = [];

    /**
     * Menu constructor.
     * @param $_priority
     */
    function __construct($_priority=0){
        $this->priority = $_priority;
        $this->sort = 0;
        $this->stack = [];
    }

    /**
     * @param $name
     * @param $_priority
     * @return AccessList|mixed
     */
    function addAccessGroup($name, $_priority=0) {

        if(isset($this->stack[$name])){
            if($this->stack[$name]->getPriority() >= $_priority){
                return $this->stack[$name];
            }
            $list = new AccessList($_priority);
            $list->setStack($this->stack[$name]->getStack());
        } else {
            $list = new AccessList($_priority);
        }

        $list->setParent($this);
        $this->stack[$name] = $list;

        return $list;
    }

    /**
     * @param $name
     * @return AccessList
     */
    function getAccessGroup($name){
        return $this->stack[$name];
    }

    /**
     * @param $name
     */
    function removeAccessGroup($name){
        unset($this->stack[$name]);
    }

    /**
     * @return array
     */
    function getAccessGroups(){
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
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
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
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @param array $stack
     */
    public function setStack(array $stack)
    {
        $this->stack = $stack;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array $permission
     * @internal param array $permissions
     */
    public function setPermission(array $permission)
    {
        $this->permissions[] = $permission;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }
}