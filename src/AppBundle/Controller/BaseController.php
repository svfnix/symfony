<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 9/20/2016 AD
 * Time: 13:34
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BaseController extends Controller
{
    protected function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    public function sendMail($to, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom([$this->container->getParameter('mailer_from_email') => $this->container->getParameter('mailer_from')])
            ->setTo($to)
            ->setBody($body, 'text/html');

        return $this->get('mailer')->send($message);
    }
}