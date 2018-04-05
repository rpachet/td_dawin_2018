<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
{
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
     * @ORM\Column(name="code_barre", type="string")
     */
    private $codeBarre;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_consultations", type="integer")
     */
    private $nbConsultations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_derniere_vue", type="datetime")
     */
    private $dateDerniereVue;


    /**
     * @var ArrayCollection $evaluations
     *
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="produit", cascade={"persist","remove","merge"})
     */
    private $evaluations;


    public function __construct(){
      $this->evaluations = new ArrayCollection();
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
     * Set codeBarre
     *
     * @param integer $codeBarre
     *
     * @return Produit
     */
    public function setCodeBarre($codeBarre)
    {
        $this->codeBarre = $codeBarre;

        return $this;
    }

    /**
     * Get codeBarre
     *
     * @return int
     */
    public function getCodeBarre()
    {
        return $this->codeBarre;
    }

    /**
     * Set nbConsultations
     *
     * @param integer $nbConsultations
     *
     * @return Produit
     */
    public function setNbConsultations($nbConsultations)
    {
        $this->nbConsultations = $nbConsultations;

        return $this;
    }

    /**
     * Get nbConsultations
     *
     * @return int
     */
    public function getNbConsultations()
    {
        return $this->nbConsultations;
    }

    /**
     * Set dateDerniereVue
     *
     * @param \DateTime $dateDerniereVue
     *
     * @return Produit
     */
    public function setDateDerniereVue($dateDerniereVue)
    {
        $this->dateDerniereVue = $dateDerniereVue;

        return $this;
    }

    /**
     * Get dateDerniereVue
     *
     * @return \DateTime
     */
    public function getDateDerniereVue()
    {
        return $this->dateDerniereVue;
    }

    /**
     * Get evaluation
     *
     */
    public function getEvaluations()
    {
        return $this->evaluations;
    }

    /**
     * Add evaluation
     *
     */
    public function addEvaluation($evaluation)
    {
      $evaluation->setProduit($this);
      $this->evaluations->add($evaluation);
    }
}
