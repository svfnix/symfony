<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 9/20/2016 AD
 * Time: 13:34
 */

namespace AppBundle\Wrappers;

use AppBundle\Entity\User;
use AppBundle\Provider\Menu;
use AppBundle\Provider\PermissionManager;
use AppBundle\Provider\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BaseController extends Controller
{
    private $user_permissions = null;

    /**
     * @return mixed
     */
    protected function getUser(){
        return $this->get('security.context')->getToken()->getUser();
    }

    /**
     * @return mixed
     */
    protected function getBundle(){
        return $this->getRequest()->attributes->get('_template')->get('bundle');
    }

    /**
     * @return mixed
     */
    protected function getController(){
        return $this->getRequest()->attributes->get('_template')->get('controller');
    }

    /**
     * @return mixed
     */
    protected function getAction(){
        return $this->getRequest()->attributes->get('_template')->get('name');
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager(){
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $repository
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository($repository){
        return $this->getDoctrine()->getRepository($repository);
    }

    /**
     * @param null $bundle
     * @return PermissionManager
     */
    protected function getUserPermissions($bundle=null){

        if(!$this->user_permissions){

            $groups = $this->getUser()->getGroups();

            $permissions = [];
            foreach ($groups as $group){
                $permissions = array_merge($permissions, $group->getPermissions());
            }

            $this->user_permissions = $permissions;
        }

        if(!$bundle){
            $bundle = $this->getBundle();
        }

        $user_permissions = [];
        if(isset($this->user_permissions[$bundle])) {
            $user_permissions = $this->user_permissions[$bundle];
        }

        return new PermissionManager($user_permissions);
    }

    /**
     * @param User $user
     * @param $password
     * @return mixed
     */
    protected function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @return mixed
     */
    protected function sendMail($to, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom([$this->container->getParameter('mailer_from_email') => $this->container->getParameter('mailer_from')])
            ->setTo($to)
            ->setBody($body, 'text/html');

        return $this->get('mailer')->send($message);
    }

    /**
     * @return array
     */
    protected function adminMenu(){

        $menu = new Menu();
        $bundles = $this->getParameter('kernel.bundles');
        foreach ($bundles as $bundle){
            $bundle = new $bundle;
            if(method_exists($bundle, 'inflateAdminMenu')){
                $bundle->inflateUserMenu($menu, $this->get('router'));
            }
        }

        return $menu->getMenus();
    }

    /**
     * @return array
     */
    protected function userMenu(){

        $menu = new Menu();
        $bundles = $this->getParameter('kernel.bundles');
        foreach ($bundles as $bundle){
            $bundle = new $bundle;
            if(method_exists($bundle, 'inflateUserMenu')){
                $bundle->inflateUserMenu($menu, $this->get('router'));
            }
        }

        return $menu->getMenus();
    }

}