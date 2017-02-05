<?php

namespace Admin\NoticeBundle\Controller;

use Admin\NoticeBundle\Form\AdminNoticeNewsForm;
use AppBundle\Entity\News;
use AppBundle\Event\NewsEvent;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends AdminPanelController
{

    /**
     * @Route("/remote_list", name="admin_notice_news_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_notice_news')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:News');

        $filters = $this->getFilters($request, array_merge(
            $em->getClassMetadata(News::class)->getFieldNames(),
            $em->getClassMetadata(News::class)->getAssociationNames()
        ));
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminNoticeBundle:News:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_notice_news_delete")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function remote_delete(Request $request)
    {
        if(!$this->checkPermission('admin_notice_news_delete')){
            return $this->redirectToLogin();
        }

        $ids = $request->request->get('ids');
        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:News');
        $repo->bulkDelete($ids);

        return$this->json([
            'success' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_notice_news")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_notice_news')){
            return $this->redirectToLogin();
        }

        $this->breadcrumb()->newsIndex();
        return $this->render('AdminNoticeBundle:News:index.html.twig');
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_notice_news_add")
     */
    public function add(Request $request)
    {
        if(!$this->checkPermission('admin_notice_news_add')){
            return $this->redirectToLogin();
        }

        $news = new News();
        $form = $this->createForm(AdminNoticeNewsForm::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($news);
                $em->flush();

                $eventDispatcher = $this->get('event_dispatcher');
                $eventDispatcher->dispatch('news.sent', new NewsEvent($news));

                return $this->returnSuccess('admin_notice_news');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->newsAdd();
        return $this->render('AdminNoticeBundle:News:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'news' => $news
        ]);
    }

    /**
     * @param News $news
     * @param Request $request
     * @return string
     * @Route("/edit/{id}", name="admin_notice_news_edit", requirements={"id": "\d+"})
     */
    public function edit(News $news, Request $request)
    {
        if(!$this->checkPermission('admin_notice_news_edit')){
            return $this->redirectToLogin();
        }

        $form = $this->createForm(AdminNoticeNewsForm::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($news);
                $em->flush();

                $eventDispatcher = $this->get('event_dispatcher');
                $eventDispatcher->dispatch('news.edit', new NewsEvent($news));

                return $this->returnSuccess('admin_notice_news');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->newsEdit();
        return $this->render('AdminNoticeBundle:News:edit.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'news' => $news
        ]);
    }
}
