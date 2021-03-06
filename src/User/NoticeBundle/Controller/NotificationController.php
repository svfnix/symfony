<?php

namespace User\NoticeBundle\Controller;

use AppBundle\Entity\Notification;
use AppBundle\Event\BulkEvent;
use AppBundle\Event\NotificationEvent;
use AppBundle\Event\UserEvent;
use AppBundle\Wrappers\UserPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends UserPanelController
{

    /**
     * @Route("/remote_list", name="user_notice_notification_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Notification');

        $filters = $this->getFilters($request, array_merge(
            $em->getClassMetadata(Notification::class)->getFieldNames(),
            $em->getClassMetadata(Notification::class)->getAssociationNames()
        ));
        $filters['filters']['receiver'] = $this->getUser()->getId();
        $response = call_user_func_array([$repo, 'filter'], $filters);

        $eventDispatcher = $this->get('event_dispatcher');
        $eventDispatcher->dispatch('notification.seen.bulk', new BulkEvent($response));
        $eventDispatcher->dispatch('user.sync', new UserEvent($this->getUser()));

        return $this->render('UserNoticeBundle:Notification:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/", name="user_notice_notification")
     */
    public function index()
    {
        $this->breadcrumb()->notificationIndex();
        return $this->render('UserNoticeBundle:Notification:index.html.twig');
    }
}
