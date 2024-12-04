<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;

class PictureProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
        
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->em->persist($data);

        $data->setFilePath("/images/pictures/" . $data->getFilePath());
        $this->em->flush();
        return $data;
    }
}