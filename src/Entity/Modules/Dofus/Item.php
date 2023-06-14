<?php

namespace App\Entity\Dofus;

use App\Repository\Dofus\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $iditem;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $iditem_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     *
     * @var string
     */
    private $qty_bank;

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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

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
     * Get the value of iditem
     */ 
    public function getIditem()
    {
        return $this->iditem;
    }

    /**
     * Get the value of code
     *
     * @return  string
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string  $code
     *
     * @return  self
     */ 
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of iditem_type
     */ 
    public function getIditem_type()
    {
        return $this->iditem_type;
    }

    /**
     * Set the value of iditem_type
     *
     * @return  self
     */ 
    public function setIditem_type($iditem_type)
    {
        $this->iditem_type = $iditem_type;

        return $this;
    }

    /**
     * Set the value of iditem
     *
     * @return  self
     */ 
    public function setIditem($iditem)
    {
        $this->iditem = $iditem;

        return $this;
    }

    /**
     * Get the value of qty_bank
     *
     * @return  string
     */ 
    public function getQty_bank()
    {
        return $this->qty_bank;
    }

    /**
     * Set the value of qty_bank
     *
     * @param  string  $qty_bank
     *
     * @return  self
     */ 
    public function setQty_bank(string $qty_bank)
    {
        $this->qty_bank = $qty_bank;

        return $this;
    }
}
