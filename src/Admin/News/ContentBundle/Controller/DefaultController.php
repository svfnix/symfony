<?php

namespace Admin\News\ContentBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Wrappers\AdminPanelController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends AdminPanelController
{
    public function indexAction()
    {
        return $this->render('NewsContentBundle:Default:index.html.twig');
    }
}
