<?php

namespace Admin\Users\GroupBundle\Controller;

use AppBundle\Service\App;
use AppBundle\Wrappers\AdminPanelController;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends AdminPanelController
{
    /**
     * @param $page
     * @param $key
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="admin_users_group")
     */
    public function indexAction($page, $key, $type)
    {
        $this->breadcrumb()->actionDefault();

        $builder = new QueryBuilder();
        $builder
            ->select('*')
            ->from('AdminUsersGroupBundle:Group')
            ->orderBy('id', SORT_DESC)
            ->setFirstResult($page * 20)
            ->setMaxResults(20);

        $paging = new Paginator($page, $totalcount, $rpp);
        $pagelist = $paginator->getPagesList()

        return $this->render('AdminUsersGroupBundle:Default:index.html.twig');
    }
}
