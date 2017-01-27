<?php

namespace Admin\CommunicationBundle\Controller;

use Admin\CommunicationBundle\Form\AdminCommunicationNotificationForm;
use AppBundle\Entity\Notification;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends AdminPanelController
{/**
 * @Route("/remote_users", name="admin_communication_notification_remote_users")
 * @param Request $request
 * @return Response
 */
    public function remote_users(Request $request)
    {
        if(!$this->checkPermission('admin_communication_notification')){
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
     * @Route("/remote_list", name="admin_communication_notification_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_communication_notification')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Notification');

        $filters = $this->getFilters($request, array_merge(
            $em->getClassMetadata(Notification::class)->getFieldNames(),
            $em->getClassMetadata(Notification::class)->getAssociationNames()
        ));
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminCommunicationBundle:Notification:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_communication_notification_delete")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function remote_delete(Request $request)
    {
        if(!$this->checkPermission('admin_communication_notification_delete')){
            return $this->redirectToLogin();
        }

        $ids = $request->request->get('ids');

        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Notification');
        $repo->bulkDelete($ids);

        return$this->json([
            'success' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_communication_notification")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_communication_notification')){
            return $this->redirectToLogin();
        }

        $this->breadcrumb()->notificationIndex();
        return $this->render('AdminCommunicationBundle:Notification:index.html.twig');
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_communication_notification_add")
     */
    public function add(Request $request)
    {
        if(!$this->checkPermission('admin_communication_notification_add')){
            return $this->redirectToLogin();
        }

        $notification = new Notification();
        $form = $this->createForm(AdminCommunicationNotificationForm::class, $notification);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($notification);
                $em->flush();

                return $this->returnSuccess('admin_communication_notification');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->notificationAdd();
        return $this->render('AdminCommunicationBundle:Notification:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'notification' => $notification
        ]);
    }

    /**
     * @param Notification $notification
     * @param Request $request
     * @return string
     * @Route("/edit/{id}", name="admin_communication_notification_edit", requirements={"id": "\d+"})
     */
    public function edit(Notification $notification, Request $request)
    {
        if(!$this->checkPermission('admin_communication_notification_edit')){
            return $this->redirectToLogin();
        }

        $form = $this->createForm(AdminCommunicationNotificationForm::class, $notification);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($notification);
                $em->flush();

                return $this->returnSuccess('admin_communication_notification');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->notificationEdit();
        return $this->render('AdminCommunicationBundle:Notification:edit.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'notification' => $notification
        ]);
    }
}
