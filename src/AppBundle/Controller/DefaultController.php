<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:Mois');
        $mois = $em->getActualMonth();

        // Set la langue locale en Français
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        // L'année en cours
        $year = date('Y');
        // Le mois en cours
        $month = date('m');
        // Premier jour du mois en cours sous forme de chaine de caractère
        $firstDayOfMonth = strftime('%A', strtotime('' . $year . '-' . $month));
        $numberDayOfMonth = cal_days_in_month(CAL_GREGORIAN, date("m"), $year);
        $weeks = [];
        $now = date('d');
        $day = date('w');
        $week = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
        $actualMonth = date('n') - 1;
        $dMonth = $months[$actualMonth];
        $dday = $week[$day];

        switch ($firstDayOfMonth) {
            case 'lundi':
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
            case 'mardi':
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
            case 'mercredi':
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
            case 'jeudi':
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
            case 'vendredi':
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
            case 'samedi':
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
            case 'dimanche':
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

        return $this->render('default/index.html.twig', array(
            'dday'      => $dday,
            'dmonth'    => $dMonth,
            'now'       => $now,
            'weeks'     => $weeks,
            'plannings' => $mois,
        ));
    }

    /**
     * @Route("actual_course", name="actual_course")
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseActualMonth(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getRepository('AppBundle:Mois');
            $mois = $em->getActualMonth();
            $idActualMonth = '';
            $title = '';


            if ($mois) {

                foreach ($mois as $k => $v) {
                    $idActualMonth = $v->getId();
                    $title = $v->getNom();
                }
                $ing = $em->getListeCourses($idActualMonth);
                $response = new JsonResponse([
                    'titre' => $title,
                    'liste' => $ing
                ], Response::HTTP_OK);

                $response->headers->set('Content-Type', 'application/json');
            } else {
                throw new NotFoundHttpException("Page not found");
            }

        }
        return $response;
    }

    /**
     * @Route("next_course", name="next_course")
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseNextMonth(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getRepository('AppBundle:Mois');
            $mois = $em->getNextMonth();
            $idNextMonth = '';
            $title = '';


            if ($mois) {

                foreach ($mois as $k => $v) {
                    $idNextMonth = $v->getId();
                    $title = $v->getNom();
                }
                $ing = $em->getListeCourses($idNextMonth);
                $response = new JsonResponse([
                    'titre' => $title,
                    'liste' => $ing
                ], Response::HTTP_OK);

                $response->headers->set('Content-Type', 'application/json');
            } else {
                throw new NotFoundHttpException("Page not found");
            }

        }
        return $response;
    }

}
