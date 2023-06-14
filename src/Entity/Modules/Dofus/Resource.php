<?php

namespace App\Entity\Dofus;

use App\Repository\Dofus\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceRepository::class)
 */
class Resource
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idresource;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="integer")
     */
    private $idresource_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty_bank;

    /**
     * @ORM\Column(type="string", length="255")
     */
    private $code;

    public function __construct()
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of idresource
     */ 
    public function getIdresource()
    {
        return $this->idresource;
    }

    /**
     * Set the value of idresource
     *
     * @return  self
     */ 
    public function setIdresource($idresource)
    {
        $this->idresource = $idresource;

        return $this;
    }

    /**
     * Get the value of idresource_type
     */ 
    public function getIdresource_type()
    {
        return $this->idresource_type;
    }

    /**
     * Set the value of idresource_type
     *
     * @return  self
     */ 
    public function setIdresource_type($idresource_type)
    {
        $this->idresource_type = $idresource_type;

        return $this;
    }

    /**
     * Get the value of qty_bank
     */ 
    public function getQty_bank()
    {
        return $this->qty_bank;
    }

    /**
     * Set the value of qty_bank
     *
     * @return  self
     */ 
    public function setQty_bank($qty_bank)
    {
        $this->qty_bank = $qty_bank;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}
