<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('result')]
    private ?string $slug = null;

    /**
     * @var Collection<int, Field>
     */
    #[ORM\ManyToMany(targetEntity: Field::class, mappedBy: 'games')]
    private Collection $fields;

    /**
     * @var Collection<int, Result>
     */
    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Result::class)]
    private Collection $results;

    /**
     * @var Collection<int, GameMode>
     */
    #[ORM\ManyToMany(targetEntity: GameMode::class, mappedBy: 'games')]
    private Collection $gameModes;

    /**
     * @var Collection<int, Player>
     */
    #[ORM\ManyToMany(targetEntity: Player::class, mappedBy: 'games')]
    private Collection $players;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->gameModes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Field>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addField(Field $field): static
    {
        if (!$this->fields->contains($field)) {
            $this->fields->add($field);
            $field->addGame($this);
        }

        return $this;
    }

    public function removeField(Field $field): static
    {
        if ($this->fields->removeElement($field)) {
            $field->removeGame($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, GameMode>
     */
    public function getGameModes(): Collection
    {
        return $this->gameModes;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addGameMode(GameMode $gameMode): static
    {
        if (!$this->gameModes->contains($gameMode)) {
            $this->gameModes->add($gameMode);
            $gameMode->addGame($this);
        }

        return $this;
    }

    public function removeGameMode(GameMode $gameMode): static
    {
        if ($this->gameModes->removeElement($gameMode)) {
            $gameMode->removeGame($this);
        }

        return $this;
    }

    public function addPlayer(Player $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->addGame($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): static
    {
        if ($this->players->removeElement($player)) {
            $player->removeGame($this);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
