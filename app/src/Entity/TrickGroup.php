<?php

namespace App\Entity;

use App\Repository\TrickGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrickGroupRepository::class)
 */
class TrickGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Trick::class, inversedBy="trickGroup")
     */
    private $tricks;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTricks(): ?Trick
    {
        return $this->tricks;
    }

    public function setTricks(?Trick $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }
}
