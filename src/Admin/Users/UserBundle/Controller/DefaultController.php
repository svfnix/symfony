<?php

namespace Admin\Users\UserBundle\Controller;

use Admin\Users\UserBundle\Form\Type\UserType;
use AppBundle\Entity\User;
use AppBundle\Helper\App;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends AdminPanelController
{

    /**
     * @Route("/remote_list", name="admin_users_user_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:User');

        $filters = $this->getFilters($request, $em->getClassMetadata(User::class)->getFieldNames());
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminUsersUserBundle:Default:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_users_user_remote_delete")
     * @param Request $request
     * @return JsonResponse
     */
    public function remote_delete(Request $request)
    {
        $ids = $request->request->get('ids');

        if(!is_array($ids)){
            $ids = [$ids];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:User');
        $repo->bulkDelete($ids);

        return$this->json([
            'response' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_users_user")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $this->breadcrumb()->actionDefault();
        return $this->render('AdminUsersUserBundle:Default:index.html.twig', [
            'usergroup' => $repo->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add/{tab}", defaults={"tab": "profile"}, name="admin_users_user_add")
     */
    public function add(Request $request, $tab)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $user->setPassword(App::getInstance()->encodePassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();

                return $this->returnSuccess('admin_users_user');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        }

        $this->breadcrumb()->actionAdd();
        return $this->render('AdminUsersUserBundle:Default:add.html.twig', [
            'tab' => $tab,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'user' => $user,
            'usergroup' => $repo->findAll()
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param $tab
     * @return string
     * @Route("/edit/{id}/{tab}", name="admin_users_user_edit", defaults={"tab": "profile"}, requirements={"id": "\d+"})
     */
    public function edit(User $user, Request $request, $tab)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $user->setPassword(App::getInstance()->encodePassword($user, $user->getPassword()));
                $em->merge($user);
                $em->flush();

                return $this->returnSuccess('admin_users_user');
            } else {
                $this->addFlash(self::FLASH_ERROR, 'عملیات با خطا مواجه شد');
            }
        } else {
            $form->get('password')->setData('');
        }

        $this->breadcrumb()->actionEdit();
        return $this->render('AdminUsersUserBundle:Default:edit.html.twig', [
            'tab' => $tab,
            'form' => $form->createView(),
            'errors' => $form->getErrors(),
            'user' => $user,
            'usergroup' => $repo->findAll()
        ]);
    }
}
