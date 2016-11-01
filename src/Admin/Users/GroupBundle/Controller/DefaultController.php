<?php

namespace Admin\Users\GroupBundle\Controller;

use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends AdminPanelController
{
    /**
     * @Route("/", name="admin_users_group")
     */
    public function indexAction()
    {
        $this->getBreadCrumb()->defaultAction();
        return $this->render('AdminUsersGroupBundle:Default:index.html.twig');
    }
}
