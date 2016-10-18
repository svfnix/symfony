<?php

namespace User\Settings\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/profile", name="user_settings_profile")
     */
    public function index()
    {
        return $this->render('UserSettingsProfileBundle:Default:index.html.twig');
    }
    /**
     * @Route("/other", name="user_settings_profile_other")
     */
    public function other()
    {
        return $this->render('UserSettingsProfileBundle:Default:index.html.twig');
    }
}
