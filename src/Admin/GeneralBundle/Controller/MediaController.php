<?php

namespace Admin\GeneralBundle\Controller;

use AppBundle\Entity\Media;
use AppBundle\Service\UploaderService;
use AppBundle\Wrappers\AdminPanelController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
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

        if(is_object($node)) {
            do {
                array_unshift($return, '<li><a href="javascript:void(0)" onclick="modalMediaManager.explore(' . $node->getId() . ')">' . $node->getName() . '</a></li>');
            } while ($node = $node->getParent());
        } else if(!empty($node)) {
            array_unshift($return, $node);
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
            $nodes = $repo->findBy(['parent' => null], ['mediaType' => 'ASC', 'name' => 'ASC']);
        }

        $return = array();
        $return['success'] = 1;
        $return['node'] = $id;
        $return['content'] = $this->render('AdminGeneralBundle:Media:remote/nodes.html.twig', [
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
        $media->setMediaType(Media::FILE_TYPE_DIR);
        $media->setOwner($this->getUser());

        $em->persist($media);
        $em->flush();

        $return = array();
        $return['success'] = 1;
        $return['node'] = $id;
        $return['content'] = $this->render('AdminGeneralBundle:Media:remote/nodes.html.twig', [
            'nodes' => [$media]
        ])->getContent();

        return $this->json($return);
    }

    /**
     * @Route("/remote_upload/{id}", name="admin_general_media_remote_upload", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @param $id
     * @return Response
     */
    public function remote_upload($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Media');

        $return = array();
        $return['success'] = 0;

        $node = null;
        if($id) {
            $node = $repo->findOneBy(['id' => $id]);
            if(!$node) {
                return $this->json(['error' => 'پوشه والد موجود نیست']);
            }
        }

        /** @var UploaderService $uploader */
        $uploader = $this->get('service.uploader');
        $uploader->allowAll();

        if ($media = $uploader->upload($node, 'file')) {

            $return['success'] = 1;
            $return['node'] = $id;
            $return['content'] = $this->render('AdminGeneralBundle:Media:remote/nodes.html.twig', [
                'nodes' => [$media]
            ])->getContent();

        }

        return $this->json($return);
    }

    /**
     * @Route("/remote_search", name="admin_general_media_remote_search")
     * @param Request $request
     * @return Response
     */
    public function remote_search(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Media');

        $node = null;
        $nodes = [];

        $query = $request->request->get('query');
        if(empty($query)){
            return $this->json(['error' => 'عبارت جستجو وارد نشده است']);
        }

        $nodes = $repo->search($query);


        $return = array();
        $return['success'] = 1;
        $return['node'] = 0;
        $return['content'] = $this->render('AdminGeneralBundle:Media:remote/nodes.html.twig', [
            'nodes' => $nodes
        ])->getContent();
        $return['address'] = $this->nodeAddress('<li>جستجو :‌ ' . htmlspecialchars($query) . '</li>');

        return $this->json($return);
    }

    /**
     * @Route("/remote_delete", name="admin_general_media_remote_delete")
     * @param Request $request
     * @return Response
     */
    public function remote_delete(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AppBundle:Media');

        $selected = $request->request->get('selected');
        foreach($selected as $id){
            if($media = $repo->findOneBy(['id' => $id])){
                //$repo-delTree($node);
                $em->remove($media);
                $em->flush();
            }
        }

        $return = array();
        $return['success'] = 1;
        $return['deleted'] = $selected;

        return $this->json($return);
    }

    /**
     * @Route("/remote_move/{id}", name="admin_general_media_remote_move", requirements={"id" = "\d+"}, defaults={"id" = 0})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function remote_move($id, Request $request)
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

        $selected = $request->request->get('selected');
        if(is_array($selected)) {
            foreach ($selected as $id) {
                /** @var Media $media */
                if ($media = $repo->findOneBy(['id' => $id])) {

                    $media->setParent($node);
                    $media->setUpdatedAt();

                    $em->persist($node);
                    $em->flush();
                }
            }
        } else {
            return $this->json(['error' => 'پرونده ای جهت انتقال انتخاب نشده است']);
        }

        $return = array();
        $return['success'] = 1;

        return $this->json($return);
    }

    /**
     * @Route("/", name="admin_general_media")
     * @return Response
     */
    public function index()
    {
        return $this->render('AdminGeneralBundle:Media:index.html.twig');
    }
}
