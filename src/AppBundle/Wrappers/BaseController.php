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
use AppBundle\Provider\RoleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;


class BaseController extends Controller
{
    private $roleManager = null;

    protected function getRoleManager(){

        if($this->roleManager){
            return $this->roleManager;
        } else {

            $user = $this->get('security.context')->getToken()->getUser();
            $bundle = $this->getRequest()->attributes->get('_template')->get('bundle');
            $bundle = new $bundle;

            $this->roleManager = new RoleManager(
                $user->getRoles(),
                $bundle->getRoles()
            );
        }

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