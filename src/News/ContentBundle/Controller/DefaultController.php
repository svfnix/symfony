<?php

namespace News\ContentBundle\Controller;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->render('NewsContentBundle:Default:index.html.twig');
    }
}
