<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mois;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Security("has_role('ROLE_USER')")
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
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $translator = $this->get('translator');
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
                $translator->trans('planning.added', [
                    'mois' => $mois->getNom(),
                ])
            );
            return $this->redirectToRoute('homepage');
        }

        return $this->render('mois/new.html.twig', array(
            'mois' => $mois,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param int $month
     * @param int $year
     * @return string
     */
    function getFirstDayWeekOfMonth(int $month, int $year): array
    {
        $week = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        $firstDayNumber = date("w", mktime(0, 0, 0, $month, 1, $year));
        $firstDay = $week[$firstDayNumber];
        $weeks = [];

        switch ($firstDay) {
            case 'Lundi':
                $weeks = [
                    0 => 'Lundi',
                    1 => 'Mardi',
                    2 => 'Mercredi',
                    3 => 'Jeudi',
                    4 => 'Vendredi',
                    5 => 'Samedi',
                    6 => 'Dimanche',
                ];
                break;
            case 'Mardi':
                $weeks = [
                    0 => 'Mardi',
                    1 => 'Mercredi',
                    2 => 'Jeudi',
                    3 => 'Vendredi',
                    4 => 'Samedi',
                    5 => 'Dimanche',
                    6 => 'Lundi',
                ];
                break;
            case 'Mercredi':
                $weeks = [
                    0 => 'Mercredi',
                    1 => 'Jeudi',
                    2 => 'Vendredi',
                    3 => 'Samedi',
                    4 => 'Dimanche',
                    5 => 'Lundi',
                    6 => 'Mardi',
                ];
                break;
            case 'Jeudi':
                $weeks = [
                    0 => 'Jeudi',
                    1 => 'Vendredi',
                    2 => 'Samedi',
                    3 => 'Dimanche',
                    4 => 'Lundi',
                    5 => 'Mardi',
                    6 => 'Mercredi',
                ];
                break;
            case 'Vendredi':
                $weeks = [
                    0 => 'Vendredi',
                    1 => 'Samedi',
                    2 => 'Dimanche',
                    3 => 'Lundi',
                    4 => 'Mardi',
                    5 => 'Mercredi',
                    6 => 'Jeudi',
                ];
                break;
            case 'Samedi':
                $weeks = [
                    0 => 'Samedi',
                    1 => 'Dimanche',
                    2 => 'Lundi',
                    3 => 'Mardi',
                    4 => 'Mercredi',
                    5 => 'Jeudi',
                    6 => 'Vendredi',
                ];
                break;
            case 'Dimanche':
                $weeks = [
                    0 => 'Dimanche',
                    1 => 'Lundi',
                    2 => 'Mardi',
                    3 => 'Mercredi',
                    4 => 'Jeudi',
                    5 => 'Vendredi',
                    6 => 'Samedi',
                ];
                break;
        }

        return $weeks;
    }

    /**
     * Finds and displays a mois entity.
     *
     * @Route("/{id}", name="mois_show", methods={"GET"})
     * @param Mois $mois
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Mois $mois)
    {
        $year = $mois->getYear();
        $monthNumber = $mois->getMonthNumber() + 1;

        $firstWeek = $this->getFirstDayWeekOfMonth($monthNumber, $year);
        $numberDayOfMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $year);


        $deleteForm = $this->createDeleteForm($mois);

        return $this->render('mois/show.html.twig', array(
            'mois'        => $mois,
            'weeks'       => $firstWeek,
            'nbr'         => $numberDayOfMonth,
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
     * @Security("has_role('ROLE_USER')")
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
     * @Security("has_role('ROLE_USER')")
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
