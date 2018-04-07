<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Repas
 *
 * @ORM\Table(name="repas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RepasRepository")
 */
class Repas
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="repas", cascade={"persist","merge"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
    * @ORM\ManyToMany(targetEntity="Produit", inversedBy="repas", cascade={"persist", "merge"})
    * @ORM\JoinTable(name="Appartenir",
    *   joinColumns={@ORM\JoinColumn(name="idRepas", referencedColumnName="id")},
    *   inverseJoinColumns={@ORM\JoinColumn(name="idProduit", referencedColumnName="id")}
    * )
    */
    private $produits;



     public function __construct()
     {
         $this->produits  = new ArrayCollection();
     }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Repas
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Repas
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set user
     *
     * @param User $user
     */
    public function setUser(User $user)
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
      * Add Produit
      *
      * @param Produit $produit
      */
     public function addProduit(Produit $produit)
     {
         // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
         if (!$this->produits->contains($produit)) {
             $this->produits->add($produit);
         }
     }

     public function setProduits($items)
      {
          if ($items instanceof ArrayCollection || is_array($items)) {
              foreach ($items as $item) {
                  $this->addProduit($item);
              }
          } elseif ($items instanceof Produit) {
              $this->addProduit($items);
          } else {
              throw new Exception("$items must be an instance of Produit or ArrayCollection");
          }
      }

      /**
       * Get ArrayCollection
       *
       * @return ArrayCollection $produits
       */
      public function getProduits()
      {
          return $this->produits;
      }

}
