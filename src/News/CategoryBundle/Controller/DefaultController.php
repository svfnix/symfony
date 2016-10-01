<?php

namespace News\CategoryBundle\Controller;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('NewsCategoryBundle:Default:index.html.twig');
    }
}
