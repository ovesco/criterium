<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity
 */
class Unit
{
    const   HOMME   = 'homme';
    const   FEMME   = 'femme';
    const   TROUPE  = 'troupe';
    const   MEUTE   = 'meute';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="abbreviation", type="string", length=255)
     */
    private $abbreviation;

    /**
     * @var SubUnit[]
     *
     * @ORM\OneToMany(targetEntity="SubUnit", mappedBy="unit")
     */
    private $subUnits;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * @return Unit
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
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Unit
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     *
     * @return Unit
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subUnits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subUnit
     *
     * @param \AppBundle\Entity\SubUnit $subUnit
     *
     * @return Unit
     */
    public function addSubUnit(\AppBundle\Entity\SubUnit $subUnit)
    {
        $this->subUnits[] = $subUnit;
        $subUnit->setUnit($this);
        return $this;
    }

    /**
     * Remove subUnit
     *
     * @param \AppBundle\Entity\SubUnit $subUnit
     */
    public function removeSubUnit(\AppBundle\Entity\SubUnit $subUnit)
    {
        $this->subUnits->removeElement($subUnit);
    }

    /**
     * Get subUnits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubUnits()
    {
        return $this->subUnits;
    }

    public function getScore() {

        $score  = 0;

        foreach($this->subUnits as $subUnit)
            if($subUnit->isValid())
                $score += $subUnit->getScore();

        return $score;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
