<?php
/**
 * Created by PhpStorm.
 * User: svf
 * Date: 9/19/16
 * Time: 7:11 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends BaseController
{

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function index()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        return array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError()
        );
    }

    /**
     * @Route("/logout", name="logout")
     * @Template()
     */
    public function logout()
    {
        
    }
}