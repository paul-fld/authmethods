<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

class OAuthUserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $identifier]);

        if (!$user) {
            throw new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Expected an instance of %s.', User::class));
        }

        return $this->loadUserByIdentifier($user->getUsername());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        $username = $response->getUsername();
        $email = $response->getEmail();
        $firstName = $response->getFirstName();
        $lastName = $response->getLastName();
        $fullName = trim($firstName . ' ' . $lastName);

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (null === $user) {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email); // Correction ajoutée ici
            $user->setFullName($fullName); // Correction déjà en place
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(uniqid()); // Mot de passe fictif pour respecter les contraintes

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $user;
    }
}
