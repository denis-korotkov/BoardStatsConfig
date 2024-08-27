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
            $game->setSlug($object['slug']);
            $manager->persist($game);
        }
        $manager->flush();
    }

    private function data()
    {
        return [
            ['name' => 'Runebound', 'slug' => 'runebound'],
            ['name' => 'Дурак', 'slug' => 'durak'],
            ['name' => 'Nemesis', 'slug' => 'nemesis'],
            ['name' => 'Uno', 'slug' => 'uno'],
            ['name' => 'Каркассон', 'slug' => 'carcassonne'],
            ['name' => 'Бэнг!', 'slug' => 'bang'],
            ['name' => 'Неон', 'slug' => 'neon'],
        ];
    }
}
