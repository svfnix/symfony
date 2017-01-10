<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 9/19/16
 * Time: 7:11 PM
 */

namespace AppBundle\Controller;

use AppBundle\Wrappers\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends BaseController
{

    /**
     * @Route("/login", name="login")
     */
    public function index()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('AppBundle:Login:index.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        
    }
}