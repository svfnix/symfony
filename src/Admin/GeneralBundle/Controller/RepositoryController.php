<?php

namespace Admin\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RepositoryController extends Controller
{
    /**
     * @Route("users", name="admin_general_repository_user")
     * @param Request $request
     * @return Response
     */
    public function user(Request $request)
    {
        $query = $request->query->get('query');
        $page = $request->query->getInt('page');

        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:User');

        $response = $repo->filter($query, $page, 10, 'fullname', 'ASC', null);

        $items = [];
        foreach ($response as $item){
            $items[] = [
                'id' => $item->getId(),
                'fullname' => $item->getFullname(),
                'email' => $item->getEmail()
            ];
        }

        return $this->json([
            'total_count' => $response->count(),
            'items' => $items,
            'incomplete_results' => ((($page + 1) * 10) < $response->count()) ? true : false
        ]);
    }
}
