<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 10/25/16
 * Time: 9:19 PM
 */

namespace AppBundle\Wrappers;


use Symfony\Component\HttpFoundation\Response;

class UserPanelController extends BaseController
{
    protected function render($view, array $parameters = array(), Response $response = null){
        return parent::render($view, array_merge($parameters, ['user_menu' => $this->userMenu()]));
    }
}