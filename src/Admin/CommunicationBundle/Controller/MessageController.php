<?php

namespace Admin\CommunicationBundle\Controller;

use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MessageController extends AdminPanelController
{
    /**
     * @Route("/", name="admin_communication_message")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_communication_message')){
            return $this->redirectToLogin();
        }
    }
}
