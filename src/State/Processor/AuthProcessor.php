<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Useful\Routes\AuthRoute;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $hashedPassword
    ) {}
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $routeNameRegister = $operation->getName() === AuthRoute::singup['name'];

        if ($data instanceof User && $routeNameRegister) {

            if ($data->getPassword()) {
                $hashedPassword = $this->hashedPassword->hashPassword($data, $data->getPassword());
                $data->setPassword($hashedPassword);
                $this->entityManager->persist($data);
                $this->entityManager->flush();
            }
        }
      
        return $data;
    }
}
