<?php


namespace App\Helper;


use App\Entity\Professor;

class ProfessorFactory implements EntityFactory
{
    public function create(string $json):Professor
    {
        $content = json_decode($json);
        $professor = new Professor();
        $professor->setNome($content->nome);
        return $professor;
    }
}