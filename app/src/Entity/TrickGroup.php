<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

class TrickGroup
{
    private string $name;
    private Collection $tricks;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function setTricks(Collection $tricks): void
    {
        $this->tricks = $tricks;
    }
}