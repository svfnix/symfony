<?php

namespace AppBundle\Helper;

class Menu
{
    const RED = 'red';
    const YELLOW = 'yellow';
    const BLUE = 'blue';
    const GREEN = 'green';

    private $priority;
    private $parent;

    private $title;
    private $sort;
    private $url;
    private $icon;
    private $target;
    private $labels = [];
    private $stack = [];
    private $tags = [];
    private $permissions = [];

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
     * @return Menu|mixed
     */
    function addMenu($name, $_priority=0) {

        if(isset($this->stack[$name])){
            if($this->stack[$name]->getPriority() >= $_priority){
                return $this->stack[$name];
            }
            $menu = new Menu($_priority);
            $menu->setLabels($this->stack[$name]->getLabels());
            $menu->setStack($this->stack[$name]->getStack());
        } else {
            $menu = new Menu($_priority);
        }

        $menu->setParent($this);
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
     * @return $this
     */
    function removeMenu($name){
        unset($this->stack[$name]);

        return $this;
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
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
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
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
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
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
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
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param $title
     * @param $color
     * @return $this
     */
    public function setLabel($title, $color)
    {
        $this->labels[] = [
            'title' => $title,
            'color' => $color
        ];

        return $this;
    }

    /**
     * @param mixed $labels
     * @return $this
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;

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
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return $this
     */
    public function refreshTags()
    {
        $this->tags = [];

        foreach($this->stack as $menu){
            $this->tags = array_merge($this->tags, $menu->tags);
        }

        return $this;
    }

    /**
     * @param $tag
     * @return $this
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;

        if($this->parent){
            $this->parent->addTag($tag);
        }

        return $this;
    }

    /**
     * @param mixed $tags
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        if($this->parent){
            $this->parent->refreshTags();
        }

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
     * @return $this
     */
    public function refreshPermissions()
    {
        $this->permissions = [];

        foreach($this->stack as $menu){
            $this->permissions = array_merge($this->permissions, $menu->permissions);
        }

        return $this;
    }

    /**
     * @param $permission
     * @return $this
     */
    public function addPermission($permission)
    {
        $this->permissions[] = $permission;

        if($this->parent){
            $this->parent->refreshPermissions();
        }

        return $this;
    }

    /**
     * @param array $permissions
     * @return $this
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        if($this->parent){
            $this->parent->refreshPermissions();
        }

        return $this;
    }
}