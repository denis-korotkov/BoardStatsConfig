<?php

namespace App\DataFixture;

use App\Entity\Field;
use App\Entity\Game;
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
            $field->setPayload($propertyAccessor->getValue($object, '[payload]'));
            $field->setSlug($propertyAccessor->getValue($object, '[slug]'));
            $manager->persist($field);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'Result', 'type' => 'select', 'payload' => ['values' => ['Lose', 'Win'], 'isBasic' => 1], 'slug' => 'result'],
            ['name' => 'Date', 'type' => 'date', 'payload' => ['isBasic' => 1], 'slug' => 'date'],
            ['name' => 'Players', 'type' => 'string', 'payload' => ['isBasic' => 1], 'slug' => 'players'],
            ['name' => 'Duration', 'type' => 'number', 'payload' => ['isBasic' => 1], 'slug' => 'duration'],
        ];
    }

    public function getDependencies(): array
    {
        return [
            GameFixture::class,
        ];
    }
}
