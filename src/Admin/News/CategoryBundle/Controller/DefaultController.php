<?php

namespace Admin\News\CategoryBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Wrappers\AdminPanelController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends AdminPanelController
{
    public function indexAction()
    {
        return $this->render('NewsCategoryBundle:Default:index.html.twig');
    }
}
