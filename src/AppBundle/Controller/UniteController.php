<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Unite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Unite controller.
 *
 * @Route("unite")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UniteController extends Controller
{
    /**
     * Lists all unite entities.
     *
     * @Route("/", name="unite_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $unites = $em->getRepository('AppBundle:Unite')->findAll();

        return $this->render('unite/index.html.twig', array(
            'unites' => $unites,
        ));
    }

    /**
     * Creates a new unite entity.
     *
     * @Route("/new", name="unite_new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $unite = new Unite();
        $form = $this->createForm('AppBundle\Form\UniteType', $unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unite);
            $em->flush();

            return $this->redirectToRoute('unite_show', array('id' => $unite->getId()));
        }

        return $this->render('unite/new.html.twig', array(
            'unite' => $unite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a unite entity.
     *
     * @Route("/{id}", name="unite_show", methods={"GET"})
     * @param Unite $unite
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Unite $unite)
    {
        $deleteForm = $this->createDeleteForm($unite);

        return $this->render('unite/show.html.twig', array(
            'unite' => $unite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing unite entity.
     *
     * @Route("/{id}/edit", name="unite_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Unite $unite
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Unite $unite)
    {
        $deleteForm = $this->createDeleteForm($unite);
        $editForm = $this->createForm('AppBundle\Form\UniteType', $unite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unite_edit', array('id' => $unite->getId()));
        }

        return $this->render('unite/edit.html.twig', array(
            'unite' => $unite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a unite entity.
     *
     * @Route("/{id}", name="unite_delete", methods={"DELETE"})
     * @param Request $request
     * @param Unite $unite
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Unite $unite)
    {
        $form = $this->createDeleteForm($unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unite);
            $em->flush();
        }

        return $this->redirectToRoute('unite_index');
    }

    /**
     * Creates a form to delete a unite entity.
     *
     * @param Unite $unite The unite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unite $unite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unite_delete', array('id' => $unite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
