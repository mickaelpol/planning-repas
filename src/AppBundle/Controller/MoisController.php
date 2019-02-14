<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mois;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mois controller.
 *
 * @Route("mois")
 */
class MoisController extends Controller
{

    /**
     * Lists all mois entities.
     *
     * @Route("/", name="mois_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $mois = $em->getRepository('AppBundle:Mois')->getMonthByUser($user);

        return $this->render('mois/index.html.twig', array(
            'mois' => $mois,
        ));
    }

    /**
     * Creates a new mois entity.
     *
     * @Route("/new", name="mois_new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $mois = new Mois();
        $user = $this->getUser();
        $mois->setUser($user);
        $form = $this->createForm('AppBundle\Form\MoisType', $mois);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $plannings = $form->getViewData()->getPlannings();

            foreach ($plannings as $planning) {
                $planning->setMois($mois);
                $planning->setUser($user);
                $em->persist($mois);
            }
            $em->flush();
            $this->addFlash(
                'success',
                'Le planning de ' . $mois->getNom() . ' à bien été ajouté !'
            );
            return $this->redirectToRoute('homepage');
        }

        return $this->render('mois/new.html.twig', array(
            'mois'      => $mois,
            'form'      => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mois entity.
     *
     * @Route("/{id}", name="mois_show", methods={"GET"})
     * @param Mois $mois
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Mois $mois)
    {
        $deleteForm = $this->createDeleteForm($mois);

        return $this->render('mois/show.html.twig', array(
            'mois'        => $mois,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mois entity.
     *
     * @Route("/{id}/edit", name="mois_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Mois $mois
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Mois $mois)
    {
        $deleteForm = $this->createDeleteForm($mois);
        $editForm = $this->createForm('AppBundle\Form\MoisType', $mois);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mois_edit', array('id' => $mois->getId()));
        }

        return $this->render('mois/edit.html.twig', array(
            'mois'        => $mois,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mois entity.
     *
     * @Route("/{id}", name="mois_delete", methods={"DELETE"})
     * @param Request $request
     * @param Mois $mois
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Mois $mois)
    {
        $form = $this->createDeleteForm($mois);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mois);
            $em->flush();
        }

        return $this->redirectToRoute('mois_index');
    }

    /**
     * Creates a form to delete a mois entity.
     *
     * @param Mois $mois The mois entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mois $mois)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mois_delete', array('id' => $mois->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
