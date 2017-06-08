<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity
 */
class Participant
{
    const NO_TIME   = 99999999;

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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="naissance", type="string", length=255)
     */
    private $naissance;

    /**
     * @var SubUnit
     *
     * @ORM\ManyToOne(targetEntity="SubUnit", inversedBy="participants")
     * @ORM\JoinColumn(name="subUnit_id", referencedColumnName="id")
     */
    private $subUnit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departMatin", type="datetime", nullable=true)
     */
    private $departMatin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arriveeMatin", type="datetime", nullable=true)
     */
    private $arriveeMatin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departCLM", type="datetime", nullable=true)
     */
    private $departCLM;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arriveeCLM", type="datetime", nullable=true)
     */
    private $arriveeCLM;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departApresMidi", type="datetime", nullable=true)
     */
    private $departApresMidi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arriveeApresMidi", type="datetime", nullable=true)
     */
    private $arriveeApresMidi;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", length=5, unique=true)
     */
    private $numero;


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
     * @return Participant
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Participant
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set naissance
     *
     * @param string $naissance
     *
     * @return Participant
     */
    public function setNaissance($naissance)
    {
        $this->naissance = $naissance;

        return $this;
    }

    /**
     * Get naissance
     *
     * @return integer
     */
    public function getNaissance()
    {
        return intval($this->naissance);
    }

    /**
     * Set departMatin
     *
     * @param \DateTime $departMatin
     *
     * @return Participant
     */
    public function setDepartMatin($departMatin)
    {
        $this->departMatin = $departMatin;

        return $this;
    }

    /**
     * Get departMatin
     *
     * @return \DateTime
     */
    public function getDepartMatin()
    {
        return $this->departMatin;
    }

    /**
     * Set arriveeMatin
     *
     * @param \DateTime $arriveeMatin
     *
     * @return Participant
     */
    public function setArriveeMatin($arriveeMatin)
    {
        $this->arriveeMatin = $arriveeMatin;

        return $this;
    }

    /**
     * Get arriveeMatin
     *
     * @return \DateTime
     */
    public function getArriveeMatin()
    {
        return $this->arriveeMatin;
    }

    /**
     * Set departCLM
     *
     * @param \DateTime $departCLM
     *
     * @return Participant
     */
    public function setDepartCLM($departCLM)
    {
        $this->departCLM = $departCLM;

        return $this;
    }

    /**
     * Get departCLM
     *
     * @return \DateTime
     */
    public function getDepartCLM()
    {
        return $this->departCLM;
    }

    /**
     * Set arriveeCLM
     *
     * @param \DateTime $arriveeCLM
     *
     * @return Participant
     */
    public function setArriveeCLM($arriveeCLM)
    {
        $this->arriveeCLM = $arriveeCLM;

        return $this;
    }

    /**
     * Get arriveeCLM
     *
     * @return \DateTime
     */
    public function getArriveeCLM()
    {
        return $this->arriveeCLM;
    }

    /**
     * Set departApresMidi
     *
     * @param \DateTime $departApresMidi
     *
     * @return Participant
     */
    public function setDepartApresMidi($departApresMidi)
    {
        $this->departApresMidi = $departApresMidi;

        return $this;
    }

    /**
     * Get departApresMidi
     *
     * @return \DateTime
     */
    public function getDepartApresMidi()
    {
        return $this->departApresMidi;
    }

    /**
     * Set arriveeApresMidi
     *
     * @param \DateTime $arriveeApresMidi
     *
     * @return Participant
     */
    public function setArriveeApresMidi($arriveeApresMidi)
    {
        $this->arriveeApresMidi = $arriveeApresMidi;

        return $this;
    }

    /**
     * Get arriveeApresMidi
     *
     * @return \DateTime
     */
    public function getArriveeApresMidi()
    {
        return $this->arriveeApresMidi;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Participant
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set subUnit
     *
     * @param \AppBundle\Entity\SubUnit $subUnit
     *
     * @return Participant
     */
    public function setSubUnit(\AppBundle\Entity\SubUnit $subUnit = null)
    {
        $this->subUnit = $subUnit;

        return $this;
    }

    /**
     * Get subUnit
     *
     * @return \AppBundle\Entity\SubUnit
     */
    public function getSubUnit()
    {
        return $this->subUnit;
    }

    /* -- */
    public function getMatinTime() {

        if($this->getSubUnit()->getUnit()->getType() == Unit::MEUTE)
            return 0;

        if($this->getDepartMatin() === null || $this->getArriveeMatin() === null)
            return self::NO_TIME;

        return $this->getArriveeMatin()->getTimestamp() - $this->getDepartMatin()->getTimestamp();
    }

    public function getCLMTime($multiple = 1) {

        if($this->getArriveeCLM() === null || $this->getDepartCLM() === null)
            return self::NO_TIME;

        return ($this->getArriveeCLM()->getTimestamp() - $this->getDepartCLM()->getTimestamp()) * $multiple;
    }

    public function getApremTime() {

        if($this->getDepartApresMidi() === null || $this->getArriveeApresMidi() === null)
            return self::NO_TIME;

        return $this->getArriveeApresMidi()->getTimestamp() - $this->getDepartApresMidi()->getTimestamp();
    }

    public function getGlobalTime($multiple = 1) {

        return $this->getMatinTime() + $this->getApremTime() + $this->getCLMTime($multiple);
    }

    public function isCountable() {

        return $this->departMatin !== null
            && $this->arriveeMatin !== null
            && $this->departCLM !== null
            && $this->arriveeCLM !== null
            && $this->departApresMidi !== null
            && $this->arriveeApresMidi !== null;
    }

    public function getPersonalResult()
    {
        return gmdate('H:i:s', $this->getGlobalTime());
    }
}
