<?php


namespace App\Helper;


use App\Entity\Projeto;

class ProjetoFactory implements EntityFactory
{
    public function create(string $json):Projeto
    {
        $content = json_decode($json);
        $projeto = new Projeto();
        $projeto->setNome($content->nome);
        $factory = new ProfessorFactory();
        $professor = $factory->create($json);
        $projeto->setOrientador($professor);
        return $projeto;
    }

}