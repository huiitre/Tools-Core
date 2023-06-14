<?php

namespace App\Entity\Dofus;

use App\Repository\Dofus\ResourceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResourceTypeRepository::class)
 */
class ResourceType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idresource_type;

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
}
