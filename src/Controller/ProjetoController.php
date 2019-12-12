<?php


namespace App\Controller;


use App\Entity\Aluno;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Helper\ProjetoFactory;
use App\Repository\ProjetoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjetoController extends GenericController
{
    public function __construct(ProjetoRepository $objectRepository, EntityManagerInterface $entityManager, ProjetoFactory $entityFactory)
    {
        parent::__construct($objectRepository, $entityManager, $entityFactory);
    }
    public function updateEntity($entity, $entityUpdate)
    {
        // TODO: Implement updateEntity() method.
    }
    public function createProject(Request $request): Response{
        $content = json_decode($request->getContent());
        $professor = $this->getDoctrine()->getRepository(Professor::class);
        $professor = $professor->find($content->orientador);
        $projeto = new Projeto();
        $projeto->setOrientador($professor);
        $projeto->setNome($content->nome);
        $projeto->setStatus(true);
        $this->entityManager->persist($projeto);
        $this->entityManager->flush();
        return new JsonResponse($projeto);
    }

    public function projetosFiltro(string $status, Request $request){
        if($status == 'true'){
            $status = 1;
        }else{
            $status = 0;
        }
        $projeto = $this->getDoctrine()->getRepository(Projeto::class);
        $projetos = $projeto->findByStatus($status);

        return new JsonResponse($projetos);
    }
}