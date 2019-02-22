<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Recette;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Recette controller.
 *
 * @Route("recette")
 */
class RecetteController extends Controller
{
    /**
     * Lists all recette entities.
     *
     * @Route("/", name="recette_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AppBundle:Recette')->findAll();

        return $this->render('recette/index.html.twig', array(
            'recettes' => $recettes,
        ));
    }

    /**
     * Lists all recette by user.
     *
     * @Route("/my-recipes/{id}", name="recette_my_index", methods={"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AppBundle:Recette')->findBy([
            'user' => $id,
        ]);

        return $this->render('recette/my_index.html.twig', array(
            'recettes' => $recettes,
        ));
    }

    /**
     * Creates a new recette entity.
     *
     * @Route("/new", name="recette_new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $recette = new Recette();
        $form = $this->createForm('AppBundle\Form\RecetteType', $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $compositions = $form->getViewData()->getCompositions();
            $etapes = $form->getViewData()->getEtapes();

            foreach ($etapes as $etape) {
                $etape->setRecette($recette);
                $em->persist($recette);
            }

            foreach ($compositions as $composition) {
                $composition->setRecette($recette);
                $em->persist($recette);
            }

            $recette->setUser($this->getUser());
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('recette.creation.success')
            );

            return $this->redirectToRoute('recette_show', array('id' => $recette->getId()));
        }

        return $this->render('recette/new.html.twig', array(
            'recette' => $recette,
            'form'    => $form->createView(),
        ));
    }

    /**
     * Finds and displays a recette entity.
     *
     * @Route("/{id}", name="recette_show", methods={"GET"})
     * @param Recette $recette
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Recette $recette)
    {
        $deleteForm = $this->createDeleteForm($recette);

        return $this->render('recette/show.html.twig', array(
            'recette'     => $recette,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing recette entity.
     *
     * @Route("/{id}/edit", name="recette_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Recette $recette
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Recette $recette)
    {
        $user = $this->getUser();
        $author = $recette->getUser();

        if ($user != $author) {
            throw $this->createNotFoundException('Cette page n\'existe pas !');
        } else {
            $deleteForm = $this->createDeleteForm($recette);
            $editForm = $this->createForm('AppBundle\Form\RecetteType', $recette);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('recette_edit', array('id' => $recette->getId()));
            }

            return $this->render('recette/edit.html.twig', array(
                'recette'     => $recette,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }
    }

    /**
     * Deletes a recette entity.
     *
     * @Route("/{id}", name="recette_delete", methods={"DELETE"})
     * @param Request $request
     * @param Recette $recette
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Recette $recette)
    {
        $form = $this->createDeleteForm($recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recette);
            $em->flush();
        }

        return $this->redirectToRoute('recette_index');
    }

    /**
     * Creates a form to delete a recette entity.
     *
     * @param Recette $recette The recette entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recette $recette)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recette_delete', array('id' => $recette->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
