<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends BaseController
{
    /**
     * @Route("/register", name="register")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function register(Request $request)
    {
        $form = $this->createFormBuilder(new User())
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);

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
            'form' => $form->createView()
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