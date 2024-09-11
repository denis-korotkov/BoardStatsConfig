<?php

namespace App\DataFixture;

use App\Entity\GameMode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class GameModeFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $gameMode = new GameMode();
            $gameMode->setName($object['name']);
            $gameMode->setSlug($object['slug']);
            $manager->persist($gameMode);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'Team win', 'slug' => 'teamWin'],
            ['name' => 'Player win', 'slug' => 'playerWin'],
        ];
    }
}
