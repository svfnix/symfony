<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/25/16
 * Time: 9:19 PM
 */

namespace AppBundle\Wrappers;


use Symfony\Component\HttpFoundation\Response;

class AdminPanelController extends BaseController
{
    private $breadcrumb;

    /**
     * @return mixed
     */
    protected function getBreadCrumb(){
        if(!$this->breadcrumb){
            $bundle = $this->getBundle();
            $bundle = new $bundle;
            $this->breadcrumb = $bundle->getBreadCrumb();
        }

        return $this->breadcrumb;
    }

    protected function render($view, array $parameters = array(), Response $response = null){
        return parent::render($view, array_merge(
            $parameters, [
                'sidebar_menu' => $this->adminMenu(),
                'breadcrumb' => $this->breadcrumb()
            ]));
    }
}