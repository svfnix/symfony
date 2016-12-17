<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/25/16
 * Time: 9:19 PM
 */

namespace AppBundle\Wrappers;


use AppBundle\Helper\Menu;
use Symfony\Component\HttpFoundation\Response;

class UserPanelController extends BaseController
{

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

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        return parent::render($view, array_merge($parameters, ['sidebar_menu' => $this->userMenu()]));
    }
}