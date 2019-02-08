<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jour;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Jour controller.
 *
 * @Route("jour")
 */
class JourController extends Controller
{
    /**
     * Lists all jour entities.
     *
     * @Route("/", name="jour_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jours = $em->getRepository('AppBundle:Jour')->findAll();

        return $this->render('jour/index.html.twig', array(
            'jours' => $jours,
        ));
    }

    /**
     * Creates a new jour entity.
     *
     * @Route("/new", name="jour_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jour = new Jour();
        $form = $this->createForm('AppBundle\Form\JourType', $jour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jour);
            $em->flush();

            return $this->redirectToRoute('jour_show', array('id' => $jour->getId()));
        }

        return $this->render('jour/new.html.twig', array(
            'jour' => $jour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jour entity.
     *
     * @Route("/{id}", name="jour_show", methods={"GET"})
     */
    public function showAction(Jour $jour)
    {
        $deleteForm = $this->createDeleteForm($jour);

        return $this->render('jour/show.html.twig', array(
            'jour' => $jour,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jour entity.
     *
     * @Route("/{id}/edit", name="jour_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Jour $jour)
    {
        $deleteForm = $this->createDeleteForm($jour);
        $editForm = $this->createForm('AppBundle\Form\JourType', $jour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jour_edit', array('id' => $jour->getId()));
        }

        return $this->render('jour/edit.html.twig', array(
            'jour' => $jour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jour entity.
     *
     * @Route("/{id}", name="jour_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Jour $jour)
    {
        $form = $this->createDeleteForm($jour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jour);
            $em->flush();
        }

        return $this->redirectToRoute('jour_index');
    }

    /**
     * Creates a form to delete a jour entity.
     *
     * @param Jour $jour The jour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Jour $jour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jour_delete', array('id' => $jour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
