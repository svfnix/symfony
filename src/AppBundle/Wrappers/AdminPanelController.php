<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/25/16
 * Time: 9:19 PM
 */

namespace AppBundle\Wrappers;


use AppBundle\Provider\Menu;
use Symfony\Component\HttpFoundation\Response;

class AdminPanelController extends BaseController
{

    /**
     * @return array
     */
    protected function adminMenu(){

        $menu = new Menu();
        $bundles = $this->getParameter('kernel.bundles');
        foreach ($bundles as $bundle){
            $bundle = new $bundle;
            if(method_exists($bundle, 'inflateAdminMenu')){
                $bundle->inflateAdminMenu($menu);
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
        return parent::render($view, array_merge(
            $parameters, [
                'sidebar_menu' => $this->adminMenu(),
                'breadcrumb' => $this->breadcrumb()->getBreadcrumb()
            ]));
    }
}