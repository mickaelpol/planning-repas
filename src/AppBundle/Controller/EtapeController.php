<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etape;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Etape controller.
 *
 * @Route("etape")
 * @Security("has_role('ROLE_ADMIN')")
 */
class EtapeController extends Controller
{
    /**
     * Lists all etape entities.
     *
     * @Route("/", name="etape_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $etapes = $em->getRepository('AppBundle:Etape')->findAll();

        return $this->render('etape/index.html.twig', array(
            'etapes' => $etapes,
        ));
    }

    /**
     * Creates a new etape entity.
     *
     * @Route("/new", name="etape_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $etape = new Etape();
        $form = $this->createForm('AppBundle\Form\EtapeType', $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etape);
            $em->flush();

            return $this->redirectToRoute('etape_show', array('id' => $etape->getId()));
        }

        return $this->render('etape/new.html.twig', array(
            'etape' => $etape,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a etape entity.
     *
     * @Route("/{id}", name="etape_show", methods={"GET"})
     */
    public function showAction(Etape $etape)
    {
        $deleteForm = $this->createDeleteForm($etape);

        return $this->render('etape/show.html.twig', array(
            'etape' => $etape,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing etape entity.
     *
     * @Route("/{id}/edit", name="etape_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Etape $etape)
    {
        $deleteForm = $this->createDeleteForm($etape);
        $editForm = $this->createForm('AppBundle\Form\EtapeType', $etape);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etape_edit', array('id' => $etape->getId()));
        }

        return $this->render('etape/edit.html.twig', array(
            'etape' => $etape,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etape entity.
     *
     * @Route("/{id}", name="etape_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Etape $etape)
    {
        $form = $this->createDeleteForm($etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etape);
            $em->flush();
        }

        return $this->redirectToRoute('etape_index');
    }

    /**
     * Creates a form to delete a etape entity.
     *
     * @param Etape $etape The etape entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etape $etape)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etape_delete', array('id' => $etape->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
