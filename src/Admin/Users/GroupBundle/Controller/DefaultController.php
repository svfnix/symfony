<?php

namespace Admin\Users\GroupBundle\Controller;

use Admin\Users\GroupBundle\Entity\Group;
use AppBundle\Service\App;
use AppBundle\Wrappers\AdminPanelController;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AdminPanelController
{

    /**
     * @Route("/list", name="admin_users_group_list")
     */
    public function list()
    {
        $datatable = $this->get('admin_users_group_group');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * @Route("/", name="admin_users_group")
     */
    public function index()
    {
        $this->breadcrumb()->actionDefault();

        $datatable = $this->get('admin_users_group_group');
        $datatable->buildDatatable();

        return $this->render('AdminUsersGroupBundle:Default:index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @param Request $request
     * @return string
     * @Route("/add", name="admin_users_group_add")
     */
    public function add(Request $request)
    {
        $form = $this->createFormBuilder(new Group())
            ->add('title', TextType::class)
            ->add('memo', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($form);
            $em->flush();

            //return $this->redirectToRoute('task_success');
        }

        return $this->render('AdminUsersGroupBundle:Default:add.html.twig', array(
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }
}
