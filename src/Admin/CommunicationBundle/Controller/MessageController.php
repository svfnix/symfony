<?php

namespace Admin\CommunicationBundle\Controller;

use Admin\CommunicationBundle\Form\AdminUserMessageForm;
use AppBundle\Entity\Message;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends AdminPanelController
{
    /**
     * @Route("/remote_users", name="admin_communication_message_remote_users")
     * @param Request $request
     * @return Response
     */
    public function remote_users(Request $request)
    {
        if(!$this->checkPermission('admin_communication_message')){
            return $this->redirectToLogin();
        }

        $query = $request->query->get('query');
        $page = $request->query->getInt('page');

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:User');

        $response = $repo->filter($query, $page, 10, 'fullname', 'ASC', null);

        $items = [];
        foreach ($response as $item){
            $items[] = [
                'id' => $item->getId(),
                'fullname' => $item->getFullname(),
                'email' => $item->getEmail()
            ];
        }

        return $this->json([
            'total_count' => $response->count(),
            'items' => $items,
            'incomplete_results' => ((($page + 1) * 10) < $response->count()) ? true : false
        ]);
    }

    /**
     * @Route("/remote_list", name="admin_communication_message_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_communication_message')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Message');

        $filters = $this->getFilters($request, $em->getClassMetadata(Message::class)->getFieldNames());
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminCommunicationBundle:Message:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/", name="admin_communication_message")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_communication_message')){
            return $this->redirectToLogin();
        }

        $this->breadcrumb()->messageIndex();
        return $this->render('AdminCommunicationBundle:Message:index.html.twig');
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_communication_message_add")
     */
    public function add(Request $request)
    {
        if(!$this->checkPermission('admin_communication_message_add')){
            return $this->redirectToLogin();
        }

        $message = new Message();
        $form = $this->createForm(AdminUserMessageForm::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($message);
                $em->flush();

                return $this->returnSuccess('admin_communication_message');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->messageAdd();
        return $this->render('AdminCommunicationBundle:Message:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'message' => $message
        ]);
    }
}
