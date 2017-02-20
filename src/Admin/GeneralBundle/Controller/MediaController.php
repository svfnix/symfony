<?php

namespace Admin\GeneralBundle\Controller;

use AppBundle\Entity\Media;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * @param Media|null $node
     * @return string
     */
    private function nodeAddress($node)
    {
        $return = [];

        if($node) {
            do {
                array_unshift($return, '<li><a href="javascript:void(0)" onclick="modalMediaManager.explore(' . $node->getId() . ')">' . $node->getName() . '</a></li>');
            } while ($node = $node->getParent());
        }

        array_unshift($return, '<li><a href="javascript:void(0)" onclick="modalMediaManager.explore(0)"><i class="fa fa-home"></i></a></li>');

        return '<ul>' . implode('', $return) . '</ul>';
    }


    /**
     * @Route("/remote_explore/{id}", name="admin_general_media_remote_explore", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @param $id
     * @return Response
     */
    public function remote_explore($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Media');

        $node = null;
        $nodes = [];
        if($id) {
            $node = $repo->findOneBy(['id' => $id]);
            if($node) {
                $nodes = $node->getChildren();
            }
        } else {
            $nodes = $repo->findBy(['parent' => null], ['name' => 'ASC']);
        }

        $return = array();
        $return['success'] = 1;
        $return['stage'] = $this->render('AdminGeneralBundle:Media:remote/nodes.html.twig', [
            'nodes' => $nodes
        ])->getContent();
        $return['address'] = $this->nodeAddress($node);

        return $this->json($return);
    }

    /**
     * @Route("/remote_create_folder/{id}", name="admin_general_media_remote_create_folder", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function remote_create_folder($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Media');

        $node = null;
        if($id) {
            $node = $repo->findOneBy(['id' => $id]);
            if(!$node) {
                return $this->json(['error' => 'پوشه والد موجود نیست']);
            }
        }

        $name = $request->request->get('name');
        if(empty($name)){
            return $this->json(['error' => 'پوشه والد موجود نیست']);
        }

        $media = new Media();
        $media->setCreatedAt();
        $media->setName($name);
        $media->setParent($node);
        $media->setMediaType(Media::FILE_TYPE_FOLDER);
        $media->setOwner($this->getUser());

        $em->persist($media);
        $em->flush();

        $return = array();
        $return['success'] = 1;
        $return['node'] = $this->render('AdminGeneralBundle:Media:remote/nodes.html.twig', [
            'nodes' => [$media]
        ])->getContent();
        $return['address'] = $this->nodeAddress($node);

        return $this->json($return);
    }

    /**
     * @Route("/", name="admin_general_media")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->render('AdminGeneralBundle:Media:index.html.twig');
    }
}
