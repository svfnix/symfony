<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 9/20/2016 AD
 * Time: 13:34
 */

namespace AppBundle\Wrappers;

use AppBundle\Entity\User;
use AppBundle\Helper\Breadcrumb;
use AppBundle\Helper\App;
use AppBundle\Helper\PermissionManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class BaseController extends Controller
{
    const FLASH_ERROR = 'error';
    const FLASH_WARNING = 'warning';
    const FLASH_NOTICE = 'notice';
    const FLASH_SUCCESS = 'success';

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_BLOCKED = 'ROLE_BLOCKED';

    /**
     * @var Breadcrumb
     */
    private $breadcrumb = null;

    private $request;
    private $namespace;
    private $bundle;
    private $controller;
    private $action;
    private $route;
    private $route_params;

    function extractRequest()
    {
        $this->request = $this->container->get('request_stack')->getCurrentRequest();

        $var = $this->request->attributes->get('_controller');
        $var = explode('::', $var);

        $this->action = $var[1];

        $var = explode('\\', $var[0]);
        $this->controller = array_pop($var);

        array_pop($var); // remove controller from path
        $this->namespace = implode('\\', $var);
        $this->bundle = implode('', $var);

        $this->route = $this->request->attributes->get('_route');
        $this->route_params = $this->request->attributes->get('_route_params');
    }

    /**
     * @return mixed
     */
    protected function getRequest()
    {
        if(!$this->request){
            $this->extractRequest();
        }

        return $this->request;
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        if(!$this->namespace){
            $this->extractRequest();
        }

        return $this->namespace;
    }

    /**
     * @return string
     */
    protected function getBundle()
    {
        if(!$this->bundle){
            $this->extractRequest();
        }

        return $this->bundle;
    }

    /**
     * @return mixed
     */
    protected function getController()
    {
        if(!$this->controller){
            $this->extractRequest();
        }

        return $this->controller;
    }

    /**
     * @return mixed
     */
    protected function getAction()
    {
        if(!$this->action){
            $this->extractRequest();
        }

        return $this->action;
    }

    /**
     * @return mixed
     */
    protected function getRoute()
    {
        if(!$this->route){
            $this->extractRequest();
        }

        return $this->route;
    }

    /**
     * @return mixed
     */
    protected function getRouteParams()
    {
        if(!$this->route_params){
            $this->extractRequest();
        }

        return $this->route_params;
    }

    /**
     * @return array
     */
    protected function getRoles(){
        return [
            'ROLE_SUPER_ADMIN' => 'مدیر کل',
            'ROLE_ADMIN' => 'مدیر بخش',
            'ROLE_USER' => 'کاربر عادی',
            'ROLE_BLOCKED' => 'کاربر تحریم شده'
        ];
    }

    /**
     * @return PermissionManager
     */
    protected function getUserPermissions()
    {
        return $this->getUser()->getPermissions();
    }

    /**
     * @return Breadcrumb
     */
    protected function breadcrumb()
    {
        if (is_null($this->breadcrumb)) {
            $bundle = implode('\\', [$this->getNamespace(), $this->getBundle()]);
            $bundle = new $bundle;
            $bundle->setContainer($this->container);

            $this->breadcrumb = $bundle->getBreadcrumb();
        }

        return $this->breadcrumb;
    }

    /**
     * @param $count
     * @param $page
     * @param $pp
     * @return array
     */
    protected function pagination($count, $page, $pp)
    {
        $max = floor($count / $pp);

        $start = $page - 3;
        if($start < 0){
            $start = 0;
        }

        $end = $page + 3;
        if($end > $max){
            $end = $max;
        }

        return [
            'current' => $page,
            'max' => $max,
            'start' => $start,
            'end' => $end
        ];
    }

    /**
     * @param User $user
     * @param $password
     * @return mixed
     */
    public function encodePassword(User $user, $password)
    {
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @return mixed
     */
    public function sendMail($to, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom([$this->getParameter('mailer_from_email') => $this->getParameter('mailer_from')])
            ->setTo($to)
            ->setBody($body, 'text/html');

        return $this->get('mailer')->send($message);
    }

    /**
     * @param $path
     * @return RedirectResponse
     */
    protected function returnSuccess($path)
    {
        $this->addFlash(self::FLASH_SUCCESS, 'عملیات با موفقیت انجام شد');
        return $this->redirectToRoute($path);
    }

    /**
     * @return Response
     */
    protected function redirectToLogin(){
        return $this->redirectToRoute('login');
    }

    /**
     * @param null $data
     * @param array $options
     * @return mixed
     */
    protected function createCustomFormBuilder($data = null, array $options = array())
    {
        return $this->get('form.factory')->createNamedBuilder(null, FormType::class, $data, $options);
    }

}