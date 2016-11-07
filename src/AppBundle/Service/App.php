<?php
namespace AppBundle\Service;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;

class App
{
    private static $instance;

    private $container;

    private $_namespace;
    private $_bundle;
    private $_controller;
    private $_action;

    private $_route;
    private $_route_params;

    function __construct(ContainerInterface $container)
    {

        $this->container = $container;

        $request = $container->get('request_stack')->getCurrentRequest();
        $controller = $request->attributes->get('_controller');
        $controller = explode('::', $controller);

        if(count($controller) > 1) {
            $this->_action = $controller[1];

            $controller = explode('\\', $controller[0]);
            $this->_controller = array_pop($controller);

            array_pop($controller); // remove controller from path
            $this->_namespace = implode('\\', $controller);
            $this->_bundle = implode('', $controller);

            $this->_route = $request->attributes->get('_route');
            $this->_route_params = $request->attributes->get('_route_params');
        }

        self::$instance = $this;

    }

    /**
     * @return bool
     */
    public function onKernelController(){
        return true;
    }

    /**
     * @return App
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * @return mixed
     */
    public function getUser(){
        return $this->container->get('security.context')->getToken()->getUser();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(){
        return $this->container->get('doctrine')->getManager();
    }

    /**
     * @param $repository
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($repository){
        return $this->container->get('doctrine')->getRepository($repository);
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->_namespace;
    }

    /**
     * @return mixed
     */
    public function getBundle()
    {
        return $this->_bundle;
    }

    /**
     * @return mixed
     */
    public function getBundleInstance(){
        $bundle = implode('\\', [$this->getNamespace(), $this->getBundle()]);
        return new $bundle();
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->_route;
    }

    /**
     * @return mixed
     */
    public function getRouteParams()
    {
        return $this->_route_params;
    }

    /**
     * @param $route
     * @param array $parameters
     * @param int $referenceType
     * @return mixed
     */
    public function route($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * @param User $user
     * @param $password
     * @return mixed
     */
    public function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

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
            ->setFrom([$this->container->getParameter('mailer_from_email') => $this->container->getParameter('mailer_from')])
            ->setTo($to)
            ->setBody($body, 'text/html');

        return $this->container->get('mailer')->send($message);
    }

}