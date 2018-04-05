<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="datetime")
     */
    private $date_naissance;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string")
     */
    private $sexe;

    /**
     * @var ArrayCollection $evaluations
     *
     * @ORM\OneToMany(targetEntity="Evaluation", mappedBy="user", cascade={"persist","remove","merge"})
     */
    private $evaluations;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->evaluations = new ArrayCollection();

    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->date_naissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
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
      $evaluation->setUser($this);
      $this->evaluations->add($evaluation);
    }
}
