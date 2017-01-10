<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\AppUserForm;
use AppBundle\Helper\App;
use AppBundle\Wrappers\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends BaseController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return string|RedirectResponse
     */
    public function index(Request $request)
    {
        $user = new User();
        $form = $this->createForm(AppUserForm::class, $user, [
            'validation_groups' => ['add']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $user->setPassword($this->encodePassword($user, $user->getPassword()));

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();

                $this->sendMail(
                    $user->getEmail(),
                    $this->get('translator')->trans('ثبت نام با موفقیت انجام شد'),
                    $this->renderView('mail/register_done.html.twig', [
                        'fullname' => $user->getFullname()
                    ])
                );

                return $this->redirect(
                    $this->generateUrl('register_success')
                );

            }
        }

        return $this->render('AppBundle:Register:index.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }

    /**
     * @Route("/register/success", name="register_success")
     */
    public function success()
    {
        return $this->render('AppBundle:Register:success.html.twig');
    }
}