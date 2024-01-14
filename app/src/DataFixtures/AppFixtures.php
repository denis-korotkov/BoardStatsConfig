<?php

namespace App\DataFixtures;

use App\Entity\Field;
use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $repository)
    {
        $this->gameRepository = $repository;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $field = new Field();
            $field->setName($object['name']);
            $field->addGame($object['game']);
            $manager->persist($field);
        }
        $manager->flush();
    }

    private function data()
    {
        return [
            ['name' => 'Runebound', 'game' => $this->getGame('Runebound')]
        ];
    }

    private function getGame(string $name) : Game{
        return $this->gameRepository->findOneBy(['name' => $name]);
    }

    public function getDependencies()
    {
        return [
            GameFixtures::class,
        ];
    }
}
