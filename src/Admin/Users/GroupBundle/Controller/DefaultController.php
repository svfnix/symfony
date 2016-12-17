<?php

namespace Admin\Users\GroupBundle\Controller;

use AppBundle\Entity\UserGroup;
use Admin\Users\GroupBundle\Form\UserGroupType;
use AppBundle\Helper\App;
use AppBundle\Wrappers\AdminPanelController;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Twig\Extensions\AppExtension;

class DefaultController extends AdminPanelController
{

    /**
     * @Route("/remote_list", name="admin_users_group_remote_list")
     * @param Request $request
     * @return Response
     */
    public function remote_list(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:UserGroup');

        $filters = $this->getFilters($request, $em->getClassMetadata(UserGroup::class)->getFieldNames());
        $response = call_user_func_array([$repo, 'filter'], $filters);

        return $this->render('AdminUsersGroupBundle:Default:remote/list.html.twig', [
            'items' => $response,
            'filters' => $filters,
            'pagination' => $this->pagination($response->count(), $filters['page'], $filters['count'])
        ]);
    }

    /**
     * @Route("/remote_delete", name="admin_users_group_remote_delete")
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
        $repo = $em->getRepository('AppBundle:UserGroup');
        $repo->bulkDelete($ids);

        return$this->json([
            'response' => '1'
        ]);
    }

    /**
     * @Route("/", name="admin_users_group")
     */
    public function index()
    {
        $this->breadcrumb()->actionDefault();
        return $this->render('AdminUsersGroupBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_users_group_add")
     */
    public function add(Request $request)
    {
        $this->breadcrumb()->actionAdd();

        $group = new UserGroup();
        $form = $this->createForm(UserGroupType::class, $group);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($group);
            $em->flush();

            //return $this->redirectToRoute('task_success');
        }

        return $this->render('AdminUsersGroupBundle:Default:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ]);
    }
}
