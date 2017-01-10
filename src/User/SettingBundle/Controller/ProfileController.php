<?php

namespace User\SettingBundle\Controller;

use AppBundle\Wrappers\UserPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use User\SettingBundle\Form\UserSettingProfileForm;

class ProfileController extends UserPanelController
{
    /**
     * @Route("/", name="user_setting_profile")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserSettingProfileForm::class, $user, [
            'validation_groups' => ['update']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($user);
                $em->flush();

                return $this->returnSuccess('user_setting_profile');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->profileIndex();
        return $this->render('UserSettingBundle:Profile:index.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
        ]);
    }
}
