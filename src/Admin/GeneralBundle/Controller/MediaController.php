<?php

namespace Admin\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * @Route("index", name="admin_general_media")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->render('AdminGeneralBundle:Media:index.html.twig');
    }
}
