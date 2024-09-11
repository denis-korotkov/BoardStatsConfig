<?php

namespace App\DataFixture;

use App\Entity\Game;
use App\Repository\GameModeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GameFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly GameModeRepository $gameModeRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $game = new Game();
            $game->setName($object['name']);
            $game->setSlug($object['slug']);
            foreach ($object['gameModes'] as $gameMode) {
                $game->addGameMode($gameMode);
            }
            $manager->persist($game);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'Runebound', 'slug' => 'runebound', 'gameModes' => $this->gameModeRepository->findBySlug(['teamWin', 'playerWin'])],
            ['name' => 'Дурак', 'slug' => 'durak', 'gameModes' => $this->gameModeRepository->findBySlug(['playerWin'])],
            ['name' => 'Nemesis', 'slug' => 'nemesis', 'gameModes' => $this->gameModeRepository->findBySlug(['teamWin', 'playerWin'])],
            ['name' => 'Uno', 'slug' => 'uno', 'gameModes' => $this->gameModeRepository->findBySlug(['playerWin'])],
            ['name' => 'Каркассон', 'slug' => 'carcassonne', 'gameModes' => $this->gameModeRepository->findBySlug(['playerWin'])],
            ['name' => 'Бэнг!', 'slug' => 'bang', 'gameModes' => $this->gameModeRepository->findBySlug(['teamWin'])],
            ['name' => 'Неон', 'slug' => 'neon', 'gameModes' => $this->gameModeRepository->findBySlug(['teamWin', 'playerWin'])],
        ];
    }

    public function getDependencies(): array
    {
        return [
            GameModeFixture::class,
        ];
    }
}
