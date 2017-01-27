<?php

namespace User\CommunicationBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Event\MessageEvent;
use AppBundle\Event\UserEvent;
use AppBundle\Wrappers\UserPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends UserPanelController
{

    /**
     * @Route("/remote_list", name="user_communication_message_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Message');

        $filters = $this->getFilters($request, array_merge(
            $em->getClassMetadata(Message::class)->getFieldNames(),
            $em->getClassMetadata(Message::class)->getAssociationNames()
        ));
        $filters['filters']['receiver'] = $this->getUser()->getId();
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('UserCommunicationBundle:Message:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/", name="user_communication_message")
     */
    public function index()
    {
        $this->breadcrumb()->messageIndex();
        return $this->render('UserCommunicationBundle:Message:index.html.twig');
    }

    /**
     * @Route("/read/{id}", name="user_communication_message_read", requirements={"id": "\d+"})
     * @param Message $message
     * @return Response
     */
    public function read(Message $message)
    {
        if($message->getStatus() != Message::STATUS_READ) {

            $event = new MessageEvent($message);
            $eventDispatcher = $this->get('event_dispatcher');
            $eventDispatcher->dispatch('message.read', $event);
        }

        $this->breadcrumb()->messageRead($message);
        return $this->render('UserCommunicationBundle:Message:read.html.twig', [
            'message' => $message
        ]);
    }
}
