<?php

namespace App\DataFixture;

use App\Entity\Player;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlayerFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $player = new Player();
            $player->setName($object['name']);
            $player->setUser($object['user']);
            $manager->persist($player);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'denis', 'user' => $this->userRepository->findOneBy(['name' => 'denis'])],
        ];
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
