<?php

namespace Admin\Users\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminUsersUserBundle:Default:index.html.twig');
    }
}
