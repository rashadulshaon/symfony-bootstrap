<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setEmail('admin@example.com')
            ->setType(RoleTypeEnum::Admin)
            ->setPlainPassword('windows_xp');

        $manager->persist($admin);
        $manager->flush();
    }
}
