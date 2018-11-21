<?php

namespace PatientBundle\Controller;

use PatientBundle\Entity\Analisis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Analisi controller.
 *
 * @Route("analisis")
 */
class AnalisisController extends Controller
{
    /**
     * Lists all analisis entities.
     *
     * @Route("/", name="analisis_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $analisis = $em->getRepository('PatientBundle:Analisis')->findAll();

        return $this->render('analisis/index.html.twig', array(
            'analisis' => $analisis,
        ));
    }

    /**
     * Creates a new analisis entity.
     *
     * @Route("/new", name="analisis_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $analisis = new Analisis();
        $form = $this->createForm('PatientBundle\Form\AnalisisType', $analisis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($analisis);
            $em->flush();

            return $this->redirectToRoute('analisis_show', array('id' => $analisis->getId()));
        }

        return $this->render('analisis/new.html.twig', array(
            'analisis' => $analisis,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a analisis entity.
     *
     * @Route("/{id}", name="analisis_show")
     * @Method("GET")
     */
    public function showAction(Analisis $analisis)
    {
        $deleteForm = $this->createDeleteForm($analisis);

        return $this->render('analisis/show.html.twig', array(
            'analisis' => $analisis,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing analisis entity.
     *
     * @Route("/{id}/edit", name="analisis_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Analisis $analisis)
    {
        $deleteForm = $this->createDeleteForm($analisis);
        $editForm = $this->createForm('PatientBundle\Form\AnalisisType', $analisis);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('analisis_edit', array('id' => $analisis->getId()));
        }

        return $this->render('analisis/edit.html.twig', array(
            'analisis' => $analisis,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a analisis entity.
     *
     * @Route("/{id}", name="analisis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Analisis $analisis)
    {
        $form = $this->createDeleteForm($analisis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($analisis);
            $em->flush();
        }

        return $this->redirectToRoute('analisis_index');
    }

    /**
     * Creates a form to delete a analisis entity.
     *
     * @param Analisis $analisis The analisis entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Analisis $analisis)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('analisis_delete', array('id' => $analisis->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
