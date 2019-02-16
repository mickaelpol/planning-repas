<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Mois;
use AppBundle\Entity\Recette;
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

    /**
     * Many Plannings have one User. This is the owning side.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="plannings")
     * @ORM\JoinColumn(name="user_oid", referencedColumnName="use_oid")
     */
    private $user;


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
     * @param Mois $mois
     *
     * @return Planning
     */
    public function setMois(Mois $mois = null)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return Mois
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set recette
     *
     * @param Recette $recette
     *
     * @return Planning
     */
    public function setRecette(Recette $recette = null)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return Recette
     */
    public function getRecette()
    {
        return $this->recette;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
