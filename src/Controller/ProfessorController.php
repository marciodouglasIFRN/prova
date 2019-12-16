<?php


namespace App\Controller;


use App\Entity\Aluno;
use App\Entity\Professor;
use App\Entity\Projeto;
use App\Helper\ProfessorFactory;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfessorController extends GenericController
{
    public function __construct(ProfessorRepository $objectRepository, EntityManagerInterface $entityManager, ProfessorFactory $entityFactory)
    {
        parent::__construct($objectRepository, $entityManager, $entityFactory);
    }

    public function inscrever(Request $request)
    {
        $content = json_decode($request->getContent());
        $aluno = $this->getDoctrine()->getRepository(Aluno::class);
        $aluno = $aluno->find($content->aluno);
        if($aluno->getInscrito()){
            return new JsonResponse("Aluno já está em um projeto",400);
        }
        $aluno->setInscrito(true);
        $this->entityManager->persist($aluno);
        $this->entityManager->flush();

        $projeto = $this->getDoctrine()->getRepository(Projeto::class);
        $projeto = $projeto->find($content->projeto);


        $projeto->addBolsista($aluno);
        $this->entityManager->persist($projeto);
        $this->entityManager->flush();

        return new JsonResponse($projeto);
    }

    public function listarProjetos(int $id, Request $request){
        $content = json_decode($request->getContent());

        $professor = $this->getDoctrine()->getRepository(Professor::class);
        $professor = $professor->find($id);

        $projeto = $this->getDoctrine()->getRepository(Projeto::class);
        $projetos = $projeto->findByProfessor($professor);


        return new JsonResponse($projetos);
    }

    public function RetirarBolsistar(Request $request)
    {
        $content = json_decode($request->getContent());
        $aluno = $this->getDoctrine()->getRepository(Aluno::class);
        $aluno = $aluno->find($content->aluno);

        $aluno->setInscrito(false);
        $this->entityManager->persist($aluno);
        $this->entityManager->flush();

        $projeto = $this->getDoctrine()->getRepository(Projeto::class);
        $projeto = $projeto->find($content->projeto);


        $projeto->removeBolsista($aluno);
        $this->entityManager->persist($projeto);
        $this->entityManager->flush();

        return new JsonResponse($projeto);
    }


    public function updateEntity($entity, $entityUpdate)
    {
        // TODO: Implement updateEntity() method.
    }
}