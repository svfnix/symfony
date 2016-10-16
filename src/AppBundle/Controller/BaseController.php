<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 9/20/2016 AD
 * Time: 13:34
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Knp\Menu\MenuFactory;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Renderer\ListRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BaseController extends Controller
{
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

        $factory = new MenuFactory();
        $renderer = new ListRenderer(new Matcher());

        $menus = [];
        $bundles = $this->getParameter('kernel.bundles');
        foreach ($bundles as $bundle){
            $bundle = new $bundle;
            if(method_exists($bundle, 'getUserMenu')){
                $menu = $bundle->getUserMenu($factory);
                if(is_array($menu)){
                    $menu['menu'] = $renderer->render($menu['menu']);
                    $menus[$menu['order']][] = $menu;
                }
            }
        }

        return $menus;
    }

}