<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $form = $this->createFormBuilder(new User())
            ->add('username', TextType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()){

            $data = $form->getData();
            $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneByUsernameOrEmail($data->getUsername());

            if(is_object($user)){
                dump($user);
                die();
            }

            return $this->redirect(
                $this->generateUrl('recover_success')
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