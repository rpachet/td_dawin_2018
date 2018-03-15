<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var int
     *
     * @ORM\Column(name="code_barre", type="integer")
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
}

