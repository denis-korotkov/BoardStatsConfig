<?php

namespace App\DataFixture;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $game = new Game();
            $game->setName($object['name']);
            $manager->persist($game);
        }
        $manager->flush();
    }

    private function data()
    {
        return [
            ['name' => 'Runebound'],
            ['name' => 'Дурак'],
            ['name' => 'Nemesis'],
            ['name' => 'Uno'],
            ['name' => 'Каркассон'],
            ['name' => 'Бэнг!'],
            ['name' => 'Неон'],
        ];
    }
}
