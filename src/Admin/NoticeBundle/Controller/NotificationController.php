<?php

namespace Admin\NoticeBundle\Controller;

use Admin\NoticeBundle\Form\AdminNoticeNotificationForm;
use AppBundle\Entity\Notification;
use AppBundle\Event\BulkEvent;
use AppBundle\Event\NotificationEvent;
use AppBundle\Event\UserEvent;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends AdminPanelController
{
    /**
     * @Route("/remote_list", name="admin_notice_notification_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_notice_notification')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Notification');

        $filters = $this->getFilters($request, array_merge(
            $em->getClassMetadata(Notification::class)->getFieldNames(),
            $em->getClassMetadata(Notification::class)->getAssociationNames()
        ));
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminNoticeBundle:Notification:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_notice_notification_delete")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function remote_delete(Request $request)
    {
        if(!$this->checkPermission('admin_notice_notification_delete')){
            return $this->redirectToLogin();
        }

        $ids = $request->request->get('ids');

        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Notification');
        $repo->bulkDelete($ids);

        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->dispatch('user.sync', new UserEvent($this->getUser()));

        return$this->json([
            'success' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_notice_notification")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_notice_notification')){
            return $this->redirectToLogin();
        }

        $this->breadcrumb()->notificationIndex();
        return $this->render('AdminNoticeBundle:Notification:index.html.twig');
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_notice_notification_add")
     */
    public function add(Request $request)
    {
        if(!$this->checkPermission('admin_notice_notification_add')){
            return $this->redirectToLogin();
        }

        $notification = new Notification();
        $form = $this->createForm(AdminNoticeNotificationForm::class, $notification);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($notification);
                $em->flush();

                $eventDispatcher = $this->get('event_dispatcher');
                $eventDispatcher->dispatch('notification.sent', new NotificationEvent($notification));

                return $this->returnSuccess('admin_notice_notification');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->notificationAdd();
        return $this->render('AdminNoticeBundle:Notification:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'notification' => $notification
        ]);
    }

    /**
     * @param Notification $notification
     * @param Request $request
     * @return string
     * @Route("/edit/{id}", name="admin_notice_notification_edit", requirements={"id": "\d+"})
     */
    public function edit(Notification $notification, Request $request)
    {
        if(!$this->checkPermission('admin_notice_notification_edit')){
            return $this->redirectToLogin();
        }

        $form = $this->createForm(AdminNoticeNotificationForm::class, $notification);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($notification);
                $em->flush();

                $eventDispatcher = $this->get('event_dispatcher');
                $eventDispatcher->dispatch('notification.edit', new NotificationEvent($notification));

                return $this->returnSuccess('admin_notice_notification');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->notificationEdit();
        return $this->render('AdminNoticeBundle:Notification:edit.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'notification' => $notification
        ]);
    }
}
