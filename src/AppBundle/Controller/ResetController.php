<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Helper\App;
use AppBundle\Wrappers\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetController extends BaseController
{
    /**
     * @Route("/reset", name="reset")
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index(Request $request)
    {
        $form = $this
            ->createFormBuilder(new User())
            ->add('email', EmailType::class)
            ->getForm();

        $form->handleRequest($request);

        $errors = null;
        if ($form->isSubmitted()){

            $data = $form->getData();
            $errors = $this->get('validator')->validate($data->getEmail(), [
                new Email(),
                new NotBlank()
            ]);

            if (!count($errors)) {

                $em = App::getInstance()->getEntityManager();

                $user = $em
                    ->getRepository('AppBundle:User')
                    ->findOneByEmail($data->getEmail());

                if (is_object($user)) {

                    $e_token = uniqid(mt_rand(), true);
                    $c_token = uniqid(mt_rand(), true);

                    $user->setResetPasswordToken(password_hash($e_token, PASSWORD_BCRYPT, ['salt' => $c_token]));
                    $em->flush();

                    $response = new Response();
                    $response->headers->setCookie(new Cookie('rps', $c_token, 0, '/', null, false, false));
                    $response->send();

                    App::getInstance()->sendMail(
                        $user->getEmail(),
                        $this->get('translator')->trans('Verification link'),
                        $this->renderView('mail/reset_password_verification.html.twig', [
                            'fullname' => $user->getFullname(),
                            'token' => $e_token,
                        ])
                    );
                }

                return $this->redirectToRoute('reset_success');
            } else {
                $errors = $this->get('translator')->trans('آدرس ایمیل معتبر نمی باشد');
            }

        }

        return [
            'error' => $errors,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/reset/token/{e_token}", name="reset_update")
     * @Template()
     * @param Request $request
     * @param $e_token
     * @return array
     */
    public function update(Request $request, $e_token)
    {

        $c_token = $request->cookies->get('rps');

        if(empty($c_token)){
            return $this->render('alert/error.html.twig', ['message' => 'به نظر میرسد این درخواست از طریق این دستگاه ارسال نشده است']);
        }

        $token = password_hash($e_token, PASSWORD_BCRYPT, ['salt' => $c_token]);

        $em = App::getInstance()->getEntityManager();

        $user = $em
            ->getRepository('AppBundle:User')
            ->findOneByResetPasswordToken($token);

        if(!is_object($user)){
            return $this->render('alert/error.html.twig', ['message' => 'درخواست معتبر نیست یا منقضی شده است']);
        }

        $form = $this
            ->createFormBuilder(new User())
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->get('password')->isValid()){

            $data = $form->getData();

            $user->generateSalt();
            $user->setPassword(App::getInstance()->encodePassword($user, $data->getPassword()));
            $user->setResetPasswordToken(null);
            $em->flush();

            $response = new Response();
            $response->headers->clearCookie('rps');
            $response->send();

            App::getInstance()->sendMail(
                $user->getEmail(),
                $this->get('translator')->trans('رمز عبور شما تغییر یافت'),
                $this->renderView('mail/reset_password_done.html.twig', [
                    'fullname' => $user->getFullname()
                ])
            );

            return $this->redirectToRoute('reset_done');

        }


        return [
            'error' => null,
            'token' => $token,
            'form' => $form->createView()
            ];
    }

    /**
     * @Route("/reset/success", name="reset_success")
     * @Template()
     */
    public function success()
    {
    }

    /**
     * @Route("/reset/done", name="reset_done")
     * @Template()
     */
    public function done()
    {
    }
}