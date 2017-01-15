<?php

namespace Admin\UserBundle\Controller;

use Admin\UserBundle\Form\AdminUserUserForm;
use AppBundle\Entity\User;
use AppBundle\Helper\App;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends AdminPanelController
{

    /**
     * @Route("/remote_list", name="admin_user_user_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {
        if(!$this->checkPermission('admin_user_user')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:User');

        $filters = $this->getFilters($request, $em->getClassMetadata(User::class)->getFieldNames());
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminUserBundle:User:remote/list.html.twig', [
            'items' => $response,
            'roles' => $this->getRoles(),
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_user_user_remote_delete")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function remote_delete(Request $request)
    {
        if(!$this->checkPermission('admin_user_user_delete')){
            return $this->redirectToLogin();
        }

        $ids = $request->request->get('ids');

        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:User');
        $repo->bulkDelete($ids);

        return $this->json([
            'response' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_user_user")
     * @return RedirectResponse|Response
     */
    public function index()
    {
        if(!$this->checkPermission('admin_user_user')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $this->breadcrumb()->userIndex();
        return $this->render('AdminUserBundle:User:index.html.twig', [
            'roles' => $this->getRoles(),
            'usergroups' => $repo->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @Route("/add/{tab}", defaults={"tab": "profile"}, name="admin_user_user_add")
     * @return RedirectResponse|Response
     */
    public function add(Request $request, $tab)
    {
        if(!$this->checkPermission('admin_user_user_add')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $user = new User();
        $form = $this->createForm(AdminUserUserForm::class, $user, [
            'validation_groups' => ['add']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $user->setPassword($this->encodePassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();

                return $this->returnSuccess('admin_user_user');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->userAdd();
        return $this->render('AdminUserBundle:User:add.html.twig', [
            'tab' => $tab,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'user' => $user,
            'usergroups' => $repo->findAll(),
            'roles' => $this->getRoles()
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param $tab
     * @Route("/edit/{id}/{tab}", name="admin_user_user_edit", defaults={"tab": "profile"}, requirements={"id": "\d+"})
     * @return RedirectResponse|Response
     */
    public function edit(User $user, Request $request, $tab)
    {
        if(!$this->checkPermission('admin_user_user_edit')){
            return $this->redirectToLogin();
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $default_password = $user->getPassword();
        $form = $this->createForm(AdminUserUserForm::class, $user, [
            'validation_groups' => ['update']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $update_password = $user->getPassword();
                if(empty($update_password)){
                    $user->setPassword($default_password);
                }else{
                    $user->setPassword($this->encodePassword($user, $update_password));
                }

                $em->merge($user);
                $em->flush();

                return $this->returnSuccess('admin_user_user');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        } else {
            $user->setPassword(null);
            $form->setData($user);
        }

        $this->breadcrumb()->userEdit();
        return $this->render('AdminUserBundle:User:edit.html.twig', [
            'tab' => $tab,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'user' => $user,
            'usergroups' => $repo->findAll(),
            'roles' => $this->getRoles()
        ]);
    }
}
