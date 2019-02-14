<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table(name="use_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="use_oid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * One User has many plannings. This is the inverse side.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Planning", mappedBy="user")
     */
    private $plannings;

    /**
     * One User has many Mois. This is the inverse side.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mois", mappedBy="user")
     */
    private $mois;


    public function __construct()
    {
        parent::__construct();
        $this->mois = new ArrayCollection();
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
     * @return mixed
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * @param mixed $mois
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    }
}

