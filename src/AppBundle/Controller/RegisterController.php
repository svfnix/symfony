<?php

namespace AppBundle\Controller;

use AppBundle\Form\RegisterFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegisterController extends BaseController
{
    /**
     * @Route("/register", name="register")
     * @Template()
     */
    public function register()
    {
        $form = $this->createForm(RegisterFormType::class);

        if ($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();
            $user->setPassword($this->encodePassword($user, $user->getPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            return $this->redirect(
                $this->generateUrl('register_success')
            );

        }

        return array(
            'form' => $form->createView(),
            'error' => null
        );
    }

    /**
     * @Route("/register/success", name="register_success")
     * @Template()
     */
    public static function success()
    {

    }
}