<?php

namespace Admin\Users\GroupBundle\Controller;

use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AdminPanelController
{
    /**
     * @Route("/", name="admin_users_group")
     */
    public function indexAction(Request $request)
    {
        file_put_contents('controller.txt', print_r($request, 1));
        //$this->getBreadCrumb()->defaultAction();
        return $this->render('AdminUsersGroupBundle:Default:index.html.twig');
    }
}
