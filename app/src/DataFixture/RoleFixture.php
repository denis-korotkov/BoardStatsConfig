<?php

namespace App\DataFixture;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->data() as $object) {
            $role = new Role();
            $role->setRole($object['name']);
            $manager->persist($role);
        }
        $manager->flush();
    }

    private function data(): array
    {
        return [
            ['role' => 'admin'],
            ['role' => 'user'],
        ];
    }
}
