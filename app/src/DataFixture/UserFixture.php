<?php

namespace App\DataFixture;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $user = new User();
            $user->setName($object['name']);
            $user->setPassword($object['password']);
            $user->setRole($object['role']);
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['name' => 'denis', 'password' => '$2y$13$cFo2OGdP2IvsNqhvVWzOr.65e3nHQetKCklyQlC9nXhKGWSVCVfzi', 'role' => 'ROLE_USER'],
        ];
    }
}
