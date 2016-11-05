<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 9/20/2016 AD
 * Time: 13:34
 */

namespace AppBundle\Wrappers;

use AppBundle\Provider\Breadcrumb;
use AppBundle\Service\App;
use AppBundle\Provider\PermissionManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BaseController extends Controller
{
    private $user_permissions = null;
    private $breadcrumb;

    /**
     * @param null $bundle
     * @return PermissionManager
     */
    protected function getUserPermissions($bundle=null){

        $app = App::getInstance();
        if(!$this->user_permissions){

            $groups = $app->getUser()->getGroups();

            $permissions = [];
            foreach ($groups as $group){
                $permissions = array_merge($permissions, $group->getPermissions());
            }

            $this->user_permissions = $permissions;
        }

        if(!$bundle){
            $bundle = $app->getBundle();
        }

        $user_permissions = [];
        if(isset($this->user_permissions[$bundle])) {
            $user_permissions = $this->user_permissions[$bundle];
        }

        return new PermissionManager($user_permissions);
    }

    /**
     * @return Breadcrumb
     */
    protected function breadcrumb()
    {
        if(!$this->breadcrumb){
            $this->breadcrumb = App::getInstance()->getBundleInstance()->getBreadcrumb();
        }

        return $this->breadcrumb;
    }

}