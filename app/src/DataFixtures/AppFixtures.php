<?php

namespace App\DataFixtures;

use App\Entity\Field;
use App\Entity\Game;
use App\Repository\GameRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $repository)
    {
        $this->gameRepository = $repository;
    }

    public function load(ObjectManager $manager): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $games = $this->gameRepository->findAll();
        foreach ($games as $game) {
            foreach ($this->data() as $object) {
                $field = new Field();
                $field->setName($object['name']);
                $field->addGame($game);
                $field->setType($object['type']);
                $field->setPayload($propertyAccessor->getValue($object, '[payload]'));
                $field->setSlug($propertyAccessor->getValue($object, '[slug]'));
                $manager->persist($field);
            }
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'Result', 'type' => 'select', 'payload' => ['values' => ['Lose', 'Win']], 'slug' => 'result'],
            ['name' => 'Date', 'type' => 'date', 'slug' => 'date' ],
            ['name' => 'Players', 'type' => 'string', 'slug' => 'players'],
            ['name' => 'Duration',  'type' => 'number', 'slug' => 'duration'],
        ];
    }

    private function getGame(string $name) : Game{
        return $this->gameRepository->findOneBy(['name' => $name]);
    }

    public function getDependencies(): array
    {
        return [
            GameFixtures::class,
        ];
    }
}
