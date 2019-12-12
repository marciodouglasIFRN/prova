<?php


namespace App\Helper;


use App\Entity\Aluno;

class AlunoFactory implements EntityFactory
{
    public function create(string $json):Aluno
    {
        $content = json_decode($json);
        var_dump($content);
        $aluno = new Aluno();
        $aluno->setNome($content->nome);
        return $aluno;
    }
}