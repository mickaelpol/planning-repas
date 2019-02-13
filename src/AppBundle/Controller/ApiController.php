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
    public function getActualMonth(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() === 'GET') {
                $em = $this->getDoctrine()->getRepository(Mois::class);
                $mois = $em->getActualMonth();

                if ($mois) {
                    $idMois = '';
                    $actualMonth = '';

                    foreach ($mois as $moi) {
                        $idMois = $moi->getId();
                        $actualMonth = $moi->getNom();
                    }
                    $ings = $em->getListeCourses($idMois);
                    $ingredient = '';
                    $unite = '';
                    $quantite = '';
                    $result = [];

                    foreach ($ings as $ing) {
                        $ingredient = $ing['ingredient'];
                        $unite = $ing['unite'];
                        $quantite = $ing['quantite'];
                        if ($unite === 'Gr') {
                            if ($quantite >= 1000) {
                                $quantite = ($quantite * 1 ) / 1000 . 'Kg';
                                $r = $ingredient . ' : ' . $quantite;
                                array_push($result, $r);
                            } else {
                                $r = $ingredient . ' : ' . $quantite .' '. $unite;
                                array_push($result, $r);
                            }
                        } elseif ($unite === 'Cl') {
                            if ($quantite >= 100) {
                                $quantite = ($quantite * 1 ) / 100 . 'L';
                                $r = $ingredient . ' : ' . $quantite;
                                array_push($result, $r);
                            } else {
                                $r = $ingredient . ' : ' . $quantite.' '.$unite;
                                array_push($result, $r);
                            }
                        } else {
                            $r = $ingredient . ' : ' . $quantite;
                            array_push($result, $r);
                        }
                    }


                    // Tableau receptionnant la liste des course du mois en cours
                    $response = new JsonResponse([
                        'titre' => $actualMonth,
                        'liste' => $result,
                    ], Response::HTTP_OK);

                    return $response;
                } else {
                    $response = new JsonResponse([
                        'titre'   => 'Erreur',
                        'message' => 'Le Mois n\'existe pas',
                    ], Response::HTTP_NOT_FOUND);

                    return $response;
                }
            } else {
                $response = new JsonResponse([
                    'titre'   => 'Erreur',
                    'message' => 'La requête est erronnée',
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
    public function getNextMonth(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() === 'GET') {
        $em = $this->getDoctrine()->getRepository(Mois::class);
        $mois = $em->getNextMonth();

        if ($mois) {
            $idMois = '';
            $actualMonth = '';

            foreach ($mois as $moi) {
                $idMois = $moi->getId();
                $actualMonth = $moi->getNom();
            }
            $ings = $em->getListeCourses($idMois);
            $ingredient = '';
            $unite = '';
            $quantite = '';
            $result = [];

            foreach ($ings as $ing) {
                $ingredient = $ing['ingredient'];
                $unite = $ing['unite'];
                $quantite = $ing['quantite'];
                if ($unite === 'Gr') {
                    if ($quantite >= 1000) {
                        $quantite = ($quantite * 1 ) / 1000 . 'Kg';
                        $r = $ingredient . ' : ' . $quantite;
                        array_push($result, $r);
                    } else {
                        $r = $ingredient . ' : ' . $quantite .' '. $unite;
                        array_push($result, $r);
                    }
                } elseif ($unite === 'Cl') {
                    if ($quantite >= 100) {
                        $quantite = ($quantite * 1 ) / 100 . 'L';
                        $r = $ingredient . ' : ' . $quantite;
                        array_push($result, $r);
                    } else {
                        $r = $ingredient . ' : ' . $quantite.' '.$unite;
                        array_push($result, $r);
                    }
                } else {
                    $r = $ingredient . ' : ' . $quantite;
                    array_push($result, $r);
                }
            }


            // Tableau receptionnant la liste des course du mois en cours
            $response = new JsonResponse([
                'titre' => $actualMonth,
                'liste' => $result,
            ], Response::HTTP_OK);

            return $response;
        } else {
            $response = new JsonResponse([
                'titre'   => 'Erreur',
                'message' => 'Le Mois n\'existe pas',
            ], Response::HTTP_NOT_FOUND);

            return $response;
        }
            } else {
                $response = new JsonResponse([
                    'titre'   => 'Erreur',
                    'message' => 'La requête est erronnée',
                ], Response::HTTP_BAD_REQUEST);

                return $response;
            }
        } else {
            throw $this->createNotFoundException('Cette page n\'existe pas !');
        }

    }

}
