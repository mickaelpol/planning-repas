<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 *
 * @ORM\Table(name="pla_planning")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanningRepository")
 */
class Planning
{
    /**
     * @var int
     *
     * @ORM\Column(name="pla_oid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mois", inversedBy="plannings")
     * @ORM\JoinColumn(name="mois_oid", referencedColumnName="moi_oid")
     */
    private $mois;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recette", inversedBy="plannings")
     * @ORM\JoinColumn(name="recette_oid", referencedColumnName="rec_oid")
     */
    private $recette;

//    /**
//     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Jour", inversedBy="plannings")
//     * @ORM\JoinColumn(name="jour_oid", referencedColumnName="jou_oid")
//     */
//    private $jour;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set mois
     *
     * @param \AppBundle\Entity\Mois $mois
     *
     * @return Planning
     */
    public function setMois(\AppBundle\Entity\Mois $mois = null)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return \AppBundle\Entity\Mois
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set recette
     *
     * @param \AppBundle\Entity\Recette $recette
     *
     * @return Planning
     */
    public function setRecette(\AppBundle\Entity\Recette $recette = null)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return \AppBundle\Entity\Recette
     */
    public function getRecette()
    {
        return $this->recette;
    }
//
//    /**
//     * Set jour
//     *
//     * @param \AppBundle\Entity\Jour $jour
//     *
//     * @return Planning
//     */
//    public function setJour(\AppBundle\Entity\Jour $jour = null)
//    {
//        $this->jour = $jour;
//
//        return $this;
//    }
//
//    /**
//     * Get jour
//     *
//     * @return \AppBundle\Entity\Jour
//     */
//    public function getJour()
//    {
//        return $this->jour;
//    }
}
