<?php

namespace App\DataFixture;

use App\Repository\FieldRepository;
use App\Repository\GameRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class GameBaseFieldsFixture extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private readonly GameRepository  $gameRepository,
        private readonly FieldRepository $fieldRepository,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $games = $this->gameRepository->findAll();
        $basicFields = $this->fieldRepository->findBasic();
        foreach ($games as $game) {
            foreach ($basicFields as $basicField) {
                $basicField->addGame($game);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GameFixture::class,
            FieldFixture::class,
        ];
    }
}
