<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Jour
 *
 * @ORM\Table(name="jou_jour")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JourRepository")
 */
class Jour
{
    /**
     * @var int
     *
     * @ORM\Column(name="jou_oid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="jou_nom", type="string", length=255)
     */
    private $nom;

//    /**
//     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Planning", mappedBy="jour", cascade={"persist"})
//     */
//    private $plannings;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plannings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Jour
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add planning
     *
     * @param \AppBundle\Entity\Planning $planning
     *
     * @return Jour
     */
    public function addPlanning(\AppBundle\Entity\Planning $planning)
    {
        $this->plannings[] = $planning;

        return $this;
    }

    /**
     * Remove planning
     *
     * @param \AppBundle\Entity\Planning $planning
     */
    public function removePlanning(\AppBundle\Entity\Planning $planning)
    {
        $this->plannings->removeElement($planning);
    }

    /**
     * Get plannings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlannings()
    {
        return $this->plannings;
    }
}
