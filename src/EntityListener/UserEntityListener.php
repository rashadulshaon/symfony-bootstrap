<?php

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: User::class)]
class UserEntityListener
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function prePersist(User $user, PrePersistEventArgs $event)
    {
        $user->setPassword($this->userPasswordHasher->hashPassword(
            $user,
            $user->getPlainPassword()
        ));
    }

    public function preUpdate(User $user, PreUpdateEventArgs $event)
    {
        $plainPassword = $user->getPlainPassword();

        if ($plainPassword) {
            $user->setPassword($this->userPasswordHasher->hashPassword(
                $user,
                $plainPassword
            ));
        }
    }
}
