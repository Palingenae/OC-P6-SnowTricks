<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Trick;
use DateTime;

class Message
{
    private User $writer;
    private Trick $trick;
    private string $content;
    private DateTime $createdAt;

    public function getWriter(): User
    {
        return $this->writer;
    }

    public function setWriter(User $writer): void
    {
        $this->writer = $writer;
    }

    public function getTrick(): Trick
    {
        return $this->trick;
    }

    public function setTrick(Trick $trick): void
    {
        $this->trick = $trick;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}