<?php

namespace Admin\UserBundle\Controller;

use Admin\UserBundle\Form\AdminUserGroupForm;
use AppBundle\Entity\UserGroup;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GroupController extends AdminPanelController
{
    /**
     * @Route("/remote_list", name="admin_user_group_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_user_group')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $filters = $this->getFilters($request, $em->getClassMetadata(UserGroup::class)->getFieldNames());
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminUserBundle:Group:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_user_group_remote_delete")
     * @param Request $request
     * @return JsonResponse
     */
    public function remote_delete(Request $request)
    {
        if(!$this->checkPermission('admin_user_group_delete')){
            return $this->redirectToLogin();
        }

        $ids = $request->request->get('ids');

        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');
        $repo->bulkDelete($ids);

        return$this->json([
            'response' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_user_group")
     */
    public function index()
    {
        if(!$this->checkPermission('admin_user_group')){
            return $this->redirectToLogin();
        }

        $this->breadcrumb()->groupIndex();
        return $this->render('AdminUserBundle:Group:index.html.twig');
    }

    /**
     * @param Request $request
     * @param $tab
     * @return string
     * @Route("/add/{tab}", name="admin_user_group_add", defaults={"tab": "profile"})
     */
    public function add(Request $request, $tab)
    {
        if(!$this->checkPermission('admin_user_group_add')){
            return $this->redirectToLogin();
        }

        $group = new UserGroup();
        $form = $this->createForm(AdminUserGroupForm::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($group);
                $em->flush();

                return $this->returnSuccess('admin_user_group');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->groupAdd();
        return $this->render('AdminUserBundle:Group:add.html.twig', [
            'tab' => $tab,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'group' => $group,
            'permissions' => $this->adminPermission()
        ]);
    }

    /**
     * @param UserGroup $group
     * @param Request $request
     * @param $tab
     * @return string
     * @Route("/edit/{id}/{tab}", name="admin_user_group_edit", defaults={"tab": "profile"}, requirements={"id": "\d+"})
     */
    public function edit(UserGroup $group, Request $request, $tab)
    {
        if(!$this->checkPermission('admin_user_group_edit')){
            return $this->redirectToLogin();
        }

        $form = $this->createForm(AdminUserGroupForm::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->merge($group);
                $em->flush();

                return $this->returnSuccess('admin_user_group');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->groupEdit();
        return $this->render('AdminUserBundle:Group:edit.html.twig', [
            'tab' => $tab,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'group' => $group,
            'permissions' => $this->adminPermission()
        ]);
    }
}
