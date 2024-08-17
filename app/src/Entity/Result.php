<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('result')]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: Game::class, inversedBy: 'results')]
    #[Groups('result')]
    private ?Game $game = null;

    #[ORM\Column]
    #[Groups('result')]
    private array $value = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?game
    {
        return $this->game;
    }

    public function setGame(?game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): static
    {
        $this->value = $value;

        return $this;
    }
}
