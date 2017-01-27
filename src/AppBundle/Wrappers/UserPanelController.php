<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/25/16
 * Time: 9:19 PM
 */

namespace AppBundle\Wrappers;


use AppBundle\Helper\Menu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPanelController extends BaseController
{
    /**
     * @return array
     */
    protected function panelMenu(){

        $menu = new Menu();
        $bundles = $this->getParameter('kernel.bundles');
        foreach ($bundles as $bundle){
            $bundle = new $bundle;
            $bundle->setContainer($this->container);
            if(method_exists($bundle, 'inflateUserMenu')){
                $bundle->inflateUserMenu($menu);
            }
        }

        return $menu->getSortedStack();
    }

    /**
     * @param Request $request
     * @param array $allowed_sorting_fields
     * @return array
     */
    protected function getFilters(Request $request, $allowed_sorting_fields=[]){

        $data = $request->request;

        $filters = [
            'search' => $data->get('search', null),
            'page' => $data->getInt('page', 0),
            'count' => $data->getInt('count', 10),
            'order_by' => $data->get('order_by', 'id'),
            'sort' => $data->get('sort', 'asc'),
            'filters' => $data->get('filters', []),
        ];

        if($filters['page'] < 0){
            $filters['page'] = 0;
        }

        if(!in_array($filters['count'], [10, 25, 50, 100])){
            $filters['count'] = 10;
        }

        if(!in_array($filters['order_by'], $allowed_sorting_fields)){
            $filters['order_by'] = null;
        }else {
            if (!in_array($filters['sort'], ['asc', 'desc'])) {
                $filters['sort'] = 'asc';
            }
        }

        return $filters;
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
            'theme_sidebar_menu' => $this->panelMenu(),
            'theme_breadcrumb' => $this->breadcrumb()->getBreadcrumb()
        ]));
    }
}