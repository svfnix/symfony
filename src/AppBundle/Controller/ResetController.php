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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetController extends BaseController
{
    /**
     * @Route("/reset", name="reset")
     * @param Request $request
     * @return string|RedirectResponse
     */
    public function index(Request $request)
    {
        $form = $this
            ->createCustomFormBuilder(new User())
            ->add('email', EmailType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        $error = null;
        if ($form->isSubmitted()){

            $data = $form->getData();
            $validation = $this->get('validator')->validate($data->getEmail(), [
                new Email(),
                new NotBlank()
            ]);

            if (count($validation)) {
                $error = $this->get('translator')->trans('آدرس ایمیل معتبر نمی باشد');
            } else {

                $em = $this->getDoctrine()->getEntityManager();
                $user = $em
                    ->getRepository('AppBundle:User')
                    ->findOneByEmail($data->getEmail())
                ;

                if (is_object($user)) {

                    $e_token = uniqid(mt_rand(), true);
                    $c_token = uniqid(mt_rand(), true);

                    $user->setResetPasswordToken(password_hash($e_token, PASSWORD_BCRYPT, ['salt' => $c_token]));
                    $em->flush();

                    $response = new Response();
                    $response->headers->setCookie(new Cookie('rps', $c_token, 0, '/', null, false, false));
                    $response->send();

                    $this->sendMail(
                        $user->getEmail(),
                        $this->get('translator')->trans('Verification link'),
                        $this->renderView('mail/reset_password_verification.html.twig', [
                            'fullname' => $user->getFullname(),
                            'token' => $e_token,
                        ])
                    );
                }

                return $this->redirectToRoute('reset_success');
            }

        }

        return $this->render('AppBundle:Reset:index.html.twig', [
            'error' => $error,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset/success", name="reset_success")
     */
    public function success()
    {
        return $this->render('AppBundle:Reset:success.html.twig');
    }

    /**
     * @Route("/reset/token/{e_token}", name="reset_update")
     * @param Request $request
     * @param $e_token
     * @return string|RedirectResponse
     */
    public function update(Request $request, $e_token)
    {

        $c_token = $request->cookies->get('rps');

        if(empty($c_token)){
            return $this->render('alert/error.html.twig', ['message' => 'به نظر میرسد این درخواست از طریق این دستگاه ارسال نشده است']);
        }

        $token = password_hash($e_token, PASSWORD_BCRYPT, ['salt' => $c_token]);

        $em = $this->getDoctrine()->getEntityManager();

        /**
         * @var User $user
         */
        $user = $em
            ->getRepository('AppBundle:User')
            ->findOneByResetPasswordToken($token)
        ;

        if(!is_object($user)){
            return $this->render('alert/error.html.twig', ['message' => 'درخواست معتبر نیست یا منقضی شده است']);
        }

        $form = $this
            ->createCustomFormBuilder(new User())
            ->add('password', PasswordType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->get('password')->isValid()){

            $data = $form->getData();

            $user->generateSalt();
            $user->setPassword($this->encodePassword($user, $data->getPassword()));
            $user->setResetPasswordToken(null);
            $em->flush();

            $response = new Response();
            $response->headers->clearCookie('rps');
            $response->send();

            $this->sendMail(
                $user->getEmail(),
                $this->get('translator')->trans('رمز عبور شما تغییر یافت'),
                $this->renderView('mail/reset_password_done.html.twig', [
                    'fullname' => $user->getFullname()
                ])
            );

            return $this->redirectToRoute('reset_done');
        }


        return $this->render('AppBundle:Reset:update_reset.html.twig', [
            'token' => $token,
            'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/reset/done", name="reset_done")
     */
    public function done()
    {
        return $this->render('AppBundle:Reset:done.html.twig');
    }
}