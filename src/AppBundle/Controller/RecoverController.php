<?php

namespace AppBundle\Controller;

use AppBundle\Form\RegisterFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class RecoverController extends BaseController
{
    /**
     * @Route("/recover", name="recover")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function recover(Request $request)
    {
        $form = $this->createForm(RegisterFormType::class);
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
     * @Route("/recover/update", name="recover_update")
     * @Template()
     */
    public static function update()
    {

    }

    /**
     * @Route("/recover/success", name="recover_success")
     * @Template()
     */
    public static function success()
    {

    }
}