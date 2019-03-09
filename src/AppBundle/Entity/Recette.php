<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Composition;
use AppBundle\Entity\Etape;
use AppBundle\Entity\Planning;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Recette
 *
 * @ORM\Table(name="rec_recette")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecetteRepository")
 * @Vich\Uploadable()
 */
class Recette
{
    /**
     * @var int
     *
     * @ORM\Column(name="rec_oid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="rec_nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Composition", mappedBy="recette", cascade={"persist", "remove"})
     */
    private $compositions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Planning", mappedBy="recette", cascade={"persist", "remove"})
     */
    private $plannings;

    /**
     * One Recette has Many etape.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Etape", mappedBy="recette", cascade={"persist", "remove"})
     */
    private $etapes;

    /**
     * Manty Recette have One user
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="recettes")
     * @ORM\JoinColumn(name="use_oid", referencedColumnName="use_oid")
     */
    private $user;

    /**
     *
     * @Vich\UploadableField(mapping="image_recettes", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(name="rec_datetime", type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->compositions = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->etapes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

    /* ******************************** */
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Recette
     * @throws \Exception
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Recette
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }
    /* ******************************** */

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
     * @return Recette
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
     * Add composition
     *
     * @param Composition $composition
     *
     * @return Recette
     */
    public function addComposition(Composition $composition)
    {
        $this->compositions[] = $composition;

        return $this;
    }

    /**
     * Remove composition
     *
     * @param Composition $composition
     */
    public function removeComposition(Composition $composition)
    {
        $this->compositions->removeElement($composition);
    }

    /**
     * Get compositions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompositions()
    {
        return $this->compositions;
    }

    /**
     * Add planning
     *
     * @param Planning $planning
     *
     * @return Recette
     */
    public function addPlanning(Planning $planning)
    {
        $this->plannings[] = $planning;

        return $this;
    }

    /**
     * Remove planning
     *
     * @param Planning $planning
     */
    public function removePlanning(Planning $planning)
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
     * Add etape
     *
     * @param Etape $etape
     *
     * @return Recette
     */
    public function addEtape(Etape $etape)
    {
        $this->etapes[] = $etape;

        return $this;
    }

    /**
     * Remove etape
     *
     * @param Etape $etape
     */
    public function removeEtape(Etape $etape)
    {
        $this->etapes->removeElement($etape);
    }

    /**
     * Get etapes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtapes()
    {
        return $this->etapes;
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
