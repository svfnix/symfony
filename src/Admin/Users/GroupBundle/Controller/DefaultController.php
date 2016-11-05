<?php

namespace Admin\Users\GroupBundle\Controller;

use AppBundle\Service\App;
use AppBundle\Wrappers\AdminPanelController;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AdminPanelController
{
    /**
     * @param $page
     * @param $sort
     * @param $search
     * @return Response
     * @Route(
     *     "/{page}/{sort}/{search}",
     *     defaults={"page" = 1, "sort" = "id", "search" = ""},
     *     name="admin_users_group"
     *     )
     */
    public function indexAction($page=0, $sort=null, $search=null)
    {
        $this->breadcrumb()->actionDefault();

        /*$builder = new QueryBuilder();
        $builder
            ->select('*')
            ->from('AdminUsersGroupBundle:Group')
            ->orderBy('id', SORT_DESC)
            ->setFirstResult($page * 20)
            ->setMaxResults(20);

        $paging = new Paginator($page, $totalcount, $rpp);
        $pagelist = $paginator->getPagesList()*/

        return $this->render('AdminUsersGroupBundle:Default:index.html.twig');
    }
}
