<?php

namespace News\CategoryBundle\Controller;

use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use News\CategoryBundle\Entity\Cat;

/**
 * Cat controller.
 *
 * @Route("/news_cat")
 */
class CatController extends BaseController
{
    /**
     * Lists all Cat entities.
     *
     * @Route("/", name="news_cat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cats = $em->getRepository('NewsCategoryBundle:Cat')->findAll();

        return $this->render('NewsCategoryBundle:cat:index.html.twig', array(
            'cats' => $cats,
        ));
    }

    /**
     * Creates a new Cat entity.
     *
     * @Route("/new", name="news_cat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cat = new Cat();
        $form = $this->createForm('News\CategoryBundle\Form\CatType', $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('news_cat_show', array('id' => $cat->getId()));
        }

        return $this->render('NewsCategoryBundle:cat:new.html.twig', array(
            'cat' => $cat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cat entity.
     *
     * @Route("/{id}", name="news_cat_show")
     * @Method("GET")
     */
    public function showAction(Cat $cat)
    {
        $deleteForm = $this->createDeleteForm($cat);

        return $this->render('NewsCategoryBundle:cat:show.html.twig', array(
            'cat' => $cat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cat entity.
     *
     * @Route("/{id}/edit", name="news_cat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cat $cat)
    {
        $deleteForm = $this->createDeleteForm($cat);
        $editForm = $this->createForm('News\CategoryBundle\Form\CatType', $cat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $cat->setUpdatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('news_cat_edit', array('id' => $cat->getId()));
        }

        return $this->render('NewsCategoryBundle:cat:edit.html.twig', array(
            'cat' => $cat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cat entity.
     *
     * @Route("/{id}", name="news_cat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cat $cat)
    {
        $form = $this->createDeleteForm($cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cat);
            $em->flush();
        }

        return $this->redirectToRoute('news_cat_index');
    }

    /**
     * Creates a form to delete a Cat entity.
     *
     * @param Cat $cat The Cat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cat $cat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('news_cat_delete', array('id' => $cat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
