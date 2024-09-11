<?php

namespace App\DataFixture;

use App\Entity\Field;
use App\Repository\GameRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


class FieldFixture extends Fixture implements DependentFixtureInterface
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $repository)
    {
        $this->gameRepository = $repository;
    }

    public function load(ObjectManager $manager): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->data() as $object) {
            $field = new Field();
            $field->setName($object['name']);
            $field->setType($object['type']);
            $fieldPayload = $propertyAccessor->getValue($object, '[payload]');
            if ($propertyAccessor->getValue($fieldPayload, '[isBasic]') != 1) {
                $games = $propertyAccessor->getValue($object, '[games]');
                foreach ($games as $game) {
                    $field->addGame($game);
                }
            }
            $field->setPayload($fieldPayload);
            $field->setSlug($propertyAccessor->getValue($object, '[slug]'));
            $manager->persist($field);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'Result', 'type' => 'select', 'payload' => ['values' => ['Lose', 'Win', 'Winner'], 'isBasic' => 1], 'slug' => 'result'],
            ['name' => 'Date', 'type' => 'date', 'payload' => ['isBasic' => 1], 'slug' => 'date'],
            ['name' => 'Players', 'type' => 'array', 'payload' => ['isBasic' => 1], 'slug' => 'players'],
            ['name' => 'Duration', 'type' => 'number', 'payload' => ['isBasic' => 1], 'slug' => 'duration'],

            ['name' => 'Game mode', 'type' => 'select', 'payload' => ['valuesType' => 'array', 'valuesArray' => 'gameMode', 'isBasic' => 1], 'slug' => 'gameMode'],

            ['name' => 'Characters', 'type' => 'map',
                'payload' => ['keysType' => 'field', 'keysField' => 'Players', 'valuesType' => 'array', 'valuesArray' => 'characters'],
                'slug' => 'characters',
                'games' => $this->gameRepository->findBySlug(['nemesis', 'runebound', 'neon', 'bang']),
            ],
        ];
    }

    public function getDependencies(): array
    {
        return [
            GameFixture::class,
        ];
    }
}
