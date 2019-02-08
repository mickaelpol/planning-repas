<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Mois
 *
 * @ORM\Table(name="moi_mois")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MoisRepository")
 * @UniqueEntity(
 *     fields={"nom"},
 *     message="Le mois de {{ value }} existe déjà, renseignez une autre valeur"
 * )
 */
class Mois
{

    /**
     * @var int
     *
     * @ORM\Column(name="moi_oid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="moi_nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     * @ORM\Column(name="moi_day", type="integer")
     */
    private $days;

    /**
     * @var int
     * @ORM\Column(name="moi_number_month", type="integer")
     */
    private $monthNumber;

    /**
     * @var int
     * @ORM\Column(name="moi_year", type="integer")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Planning", mappedBy="mois", cascade={"persist"})
     * @Assert\Count(
     *     min="1",
     *     max="31",
     *     minMessage="Le planning doit contenir au minimum 1 repas",
     *     maxMessage="Le planning doit contenir au maximum {{ limit }} repas",
     * )
     */
    private $plannings;

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->plannings = new ArrayCollection();
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
     * @return Mois
     */
    public function setNom($nom)
    {
        $year = date('Y');
        $actualMonth = date('m');
        if ($actualMonth === 12) {
            $year = $year + 1;
        }
        $this->nom = $nom . ' ' . $year;

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
     * @return Mois
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

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param int $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * Set monthNumber
     *
     * @param integer $monthNumber
     *
     * @return Mois
     */
    public function setMonthNumber($monthNumber)
    {
        $this->monthNumber = $monthNumber;

        return $this;
    }

    /**
     * Get monthNumber
     *
     * @return integer
     */
    public function getMonthNumber()
    {
        return $this->monthNumber;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Mois
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }
}
