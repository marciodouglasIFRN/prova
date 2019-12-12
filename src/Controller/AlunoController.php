<?php


namespace App\Controller;


use App\Helper\AlunoFactory;
use App\Repository\AlunoRepository;
use Doctrine\ORM\EntityManagerInterface;

class AlunoController extends GenericController
{
    public function __construct(
        AlunoRepository $objectRepository,
        EntityManagerInterface $entityManager,
        AlunoFactory $entityFactory)
    {
        parent::__construct($objectRepository, $entityManager, $entityFactory);
    }
    public function updateEntity($entity, $entityUpdate)
    {
        // TODO: Implement updateEntity() method.
    }
}