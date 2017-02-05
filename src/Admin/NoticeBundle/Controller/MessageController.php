<?php

namespace Admin\NoticeBundle\Controller;

use Admin\NoticeBundle\Form\AdminNoticeMessageForm;
use AppBundle\Entity\Message;
use AppBundle\Event\BulkEvent;
use AppBundle\Event\MessageEvent;
use AppBundle\Event\UserEvent;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends AdminPanelController
{
    /**
     * @Route("/remote_users", name="admin_notice_message_remote_users")
     * @param Request $request
     * @return Response
     */
    public function remote_users(Request $request)
    {
        if(!$this->checkPermission('admin_notice_message')){
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
     * @Route("/remote_list", name="admin_notice_message_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_notice_message')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Message');

        $filters = $this->getFilters($request, array_merge(
            $em->getClassMetadata(Message::class)->getFieldNames(),
            $em->getClassMetadata(Message::class)->getAssociationNames()
        ));
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminNoticeBundle:Message:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_notice_message_delete")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function remote_delete(Request $request)
    {
        if(!$this->checkPermission('admin_notice_message_delete')){
            return $this->redirectToLogin();
        }

        $ids = $request->request->get('ids');
        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Message');
        $repo->bulkDelete($ids);

        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->dispatch('user.sync', new UserEvent($this->getUser()));

        return$this->json([
            'success' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_notice_message")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_notice_message')){
            return $this->redirectToLogin();
        }

        $this->breadcrumb()->messageIndex();
        return $this->render('AdminNoticeBundle:Message:index.html.twig');
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_notice_message_add")
     */
    public function add(Request $request)
    {
        if(!$this->checkPermission('admin_notice_message_add')){
            return $this->redirectToLogin();
        }

        $message = new Message();
        $form = $this->createForm(AdminNoticeMessageForm::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($message);
                $em->flush();

                $eventDispatcher = $this->get('event_dispatcher');
                $eventDispatcher->dispatch('message.sent', new MessageEvent($message));

                return $this->returnSuccess('admin_notice_message');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->messageAdd();
        return $this->render('AdminNoticeBundle:Message:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'message' => $message
        ]);
    }

    /**
     * @param Message $message
     * @param Request $request
     * @return string
     * @Route("/edit/{id}", name="admin_notice_message_edit", requirements={"id": "\d+"})
     */
    public function edit(Message $message, Request $request)
    {
        if(!$this->checkPermission('admin_notice_message_edit')){
            return $this->redirectToLogin();
        }

        $form = $this->createForm(AdminNoticeMessageForm::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($message);
                $em->flush();

                $eventDispatcher = $this->get('event_dispatcher');
                $eventDispatcher->dispatch('message.edit', new MessageEvent($message));

                return $this->returnSuccess('admin_notice_message');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->messageEdit();
        return $this->render('AdminNoticeBundle:Message:edit.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'message' => $message
        ]);
    }
}
