<?php

namespace User\SettingBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Wrappers\UserPanelController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordController extends UserPanelController
{
    /**
     * @Route("/", name="user_setting_password")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this
            ->createCustomFormBuilder(new User())
            ->add('password')
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted()){

            $data = $form->getData();

            $validation = $this->get('validator')->validate($data->getPassword(), [
                new NotBlank()
            ]);

            if (count($validation)) {
                $form->get('password')->addError(new FormError($this->get('translator')->trans('رمز عبور جدید را وارد نمایید')));
            }

            if($form->get('password')->isValid()){

                $user = $this->getUser();
                $user->generateSalt();
                $user->setPassword($this->encodePassword($user, $data->getPassword()));

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($user);
                $em->flush();

                return $this->returnSuccess('user_setting_password');

            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->passwordIndex();
        return $this->render('UserSettingBundle:Password:index.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }
}
