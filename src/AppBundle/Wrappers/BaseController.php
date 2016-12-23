<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 9/20/2016 AD
 * Time: 13:34
 */

namespace AppBundle\Wrappers;

use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\App;
use AppBundle\Helper\PermissionManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;


class BaseController extends Controller
{
    const FLASH_ERROR = 'error';
    const FLASH_WARNING = 'warning';
    const FLASH_NOTICE = 'notice';
    const FLASH_SUCCESS = 'success';

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_BLOCKED = 'ROLE_BLOCKED';

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

    protected function getRoles(){
        return [
            'ROLE_ADMIN' => 'مدیر سایت',
            'ROLE_USER' => 'کاربر عادی',
            'ROLE_BLOCKED' => 'تحریم شده'
        ];
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

    /**
     * @param $count
     * @param $page
     * @param $pp
     * @return array
     */
    protected function pagination($count, $page, $pp)
    {
        $max = floor($count / $pp);

        $start = $page - 3;
        if($start < 0){
            $start = 0;
        }

        $end = $page + 3;
        if($end > $max){
            $end = $max;
        }

        return [
            'current' => $page,
            'max' => $max,
            'start' => $start,
            'end' => $end
        ];
    }

    /**
     * @param $path
     * @return RedirectResponse
     */
    protected function returnSuccess($path){
        $this->addFlash(self::FLASH_SUCCESS, 'عملیات با موفقیت انجام شد');
        return $this->redirectToRoute($path);
    }

}