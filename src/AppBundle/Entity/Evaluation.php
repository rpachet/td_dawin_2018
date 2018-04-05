<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="evaluations", cascade={"persist","merge"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="Produit", inversedBy="evaluations", cascade={"persist","merge"})
    * @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
    */
    private $produit;

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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Evaluation
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Evaluation
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set user
     *
     * @param User $user
     */
    public function setUser($user)
    {
      $this->user = $user;
    }

    /**
     * Get user
     *
     * @return User
     */
     public function getUser()
     {
       return $this->user;
     }

     /**
      * Set produit
      *
      * @param Produit $produit
      */
     public function setProduit($produit)
     {
       $this->produit = $produit;
     }

     /**
      * Get produit
      *
      * @return Produit
      */
      public function getProduit()
      {
        return $this->produit;
      }

}
