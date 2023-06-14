<?php

namespace App\Entity\Dofus;

use App\Repository\Dofus\ItemTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemTypeRepository::class)
 */
class ItemType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $iditem_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
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
}
