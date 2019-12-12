<?php


namespace App\Controller;

use App\Helper\EntityFactory;
use App\Helper\HandleRequest;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class GenericController extends AbstractController
{
    /**
     * @var ObjectRepository
     */
    protected $objectRepository;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var EntityFactory
     */
    protected $entityFactory;
    /**
     * @var handleRequest
     */
    private $handleRequest;

    public function __construct(
        ObjectRepository $objectRepository,
        EntityManagerInterface $entityManager,
        EntityFactory $entityFactory)
    {
        $this->objectRepository = $objectRepository;
        $this->entityManager = $entityManager;
        $this->entityFactory = $entityFactory;
    }
    public function create(Request $request): Response
    {
        $entity = $this->entityFactory->create($request->getContent());
        var_dump($entity);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return new JsonResponse($entity);
    }
    public function remove(int $id): Response
    {
        $this->entityManager->remove($this->objectRepository->find($id));
        $this->entityManager->flush();
        return new Response('', Response::HTTP_NO_CONTENT);
    }
    public function update(int $id, Request $request): Response
    {
        $entityUpdate =  $this->entityFactory->create($request->getContent());
        $entity = $this->objectRepository->find($id);
        if (is_null($entity)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        $this->updateEntity($entity,$entityUpdate);
        $this->entityManager->flush();
        return new JsonResponse($entity);
    }
    public function search(Request $request):Response
    {
        $entityList = $this->objectRepository->findAll();
        //var_dump($entityList);
        return new JsonResponse($entityList);
    }
    public function searchByOne(int $id):Response
    {
        return new JsonResponse($this->objectRepository->find($id));
    }
    abstract public function updateEntity($entity,$entityUpdate);
}