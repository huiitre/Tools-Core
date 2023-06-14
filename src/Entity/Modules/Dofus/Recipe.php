<?php

namespace App\Entity\Dofus;

use App\Repository\Dofus\ItemTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemTypeRepository::class)
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idrecipe;

    /**
     * @ORM\Column(type="integer")
     */
    private $idparent;

    /**
     * @ORM\Column(type="integer")
     */
    private $idenfant;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function __construct()
    {
    }

    public function getIdParent(): ?string
    {
        return $this->idparent;
    }

    public function setIdParent(string $idparent): self
    {
        $this->idparent = $idparent;

        return $this;
    }

    public function getIdEnfant(): ?string
    {
        return $this->idenfant;
    }

    public function setIdEnfant(string $idenfant): self
    {
        $this->idenfant = $idenfant;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of idrecipe
     */ 
    public function getIdrecipe()
    {
        return $this->idrecipe;
    }

    /**
     * Set the value of idrecipe
     *
     * @return  self
     */ 
    public function setIdrecipe($idrecipe)
    {
        $this->idrecipe = $idrecipe;

        return $this;
    }
}
