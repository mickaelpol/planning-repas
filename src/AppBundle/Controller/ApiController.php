<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Mois;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Api controller.
 *
 *
 *
 */
class ApiController extends Controller
{
    /**
     * @param Request $request
     * @Rest\Get(path="/api/get-actual-course", name="actual_month")
     * @return JsonResponse
     */
    public function getApiActualMonth(Request $request)
    {
        $translator = $this->get('translator');

        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() === 'GET') {
                $user = $this->getUser();
                $em = $this->getDoctrine()->getRepository(Mois::class);
                $mois = $em->getActualMonth($user);

                if ($mois) {
                    $idMois = '';
                    $actualMonth = '';

                    foreach ($mois as $moi) {
                        $idMois = $moi->getId();
                        $actualMonth = $moi->getNom();
                    }
                    $ings = $em->getListeCourses($idMois);

                    // Tableau receptionnant la liste des course du mois en cours
                    $response = new JsonResponse([
                        'titre' => $actualMonth,
                        'liste' => $ings,
                    ], Response::HTTP_OK);

                    return $response;
                } else {
                    $response = new JsonResponse([
                        'titre'   => 'Erreur',
                        'message' => $translator->trans('mois.does.not.exist'),
                    ], Response::HTTP_NOT_FOUND);

                    return $response;
                }
            } else {
                $response = new JsonResponse([
                    'titre'   => 'Erreur',
                    'message' => $translator->trans('request.error'),
                ], Response::HTTP_BAD_REQUEST);

                return $response;
            }
        } else {
            throw $this->createNotFoundException('Cette page n\'existe pas !');
        }

    }

    /**
     * @param Request $request
     * @Rest\Get(path="/api/get-next-course", name="next_month")
     * @return JsonResponse
     */
    public function getApiNextMonth(Request $request)
    {
        $translator = $this->get('translator');

        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() === 'GET') {
                $user = $this->getUser();
                $em = $this->getDoctrine()->getRepository(Mois::class);
                $mois = $em->getNextMonth($user);

                if ($mois) {
                    $idMois = '';
                    $actualMonth = '';

                    foreach ($mois as $moi) {
                        $idMois = $moi->getId();
                        $actualMonth = $moi->getNom();
                    }
                    $ings = $em->getListeCourses($idMois);

                    // Tableau receptionnant la liste des course du mois en cours
                    $response = new JsonResponse([
                        'titre' => $actualMonth,
                        'liste' => $ings,
                    ], Response::HTTP_OK);

                    return $response;
                } else {
                    $response = new JsonResponse([
                        'titre'   => 'Erreur',
                        'message' => $translator->trans('mois.does.not.exist'),
                    ], Response::HTTP_BAD_REQUEST);

                    return $response;
                }
            } else {
                $response = new JsonResponse([
                    'titre'   => 'Erreur',
                    'message' => $translator->trans('request.error'),
                ], Response::HTTP_BAD_REQUEST);

                return $response;
            }
        } else {
            throw $this->createNotFoundException('Cette page n\'existe pas !');
        }

    }

}
