<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessorRepository")
 */
class Professor implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projeto", mappedBy="orientador")
     */
    private $projetos;

    public function __construct()
    {
        $this->projetos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return Collection|Projeto[]
     */
    public function getProjetos(): Collection
    {
        return $this->projetos;
    }

    public function addProjeto(Projeto $projeto): self
    {
        if (!$this->projetos->contains($projeto)) {
            $this->projetos[] = $projeto;
            $projeto->setOrientador($this);
        }

        return $this;
    }

    public function removeProjeto(Projeto $projeto): self
    {
        if ($this->projetos->contains($projeto)) {
            $this->projetos->removeElement($projeto);
            // set the owning side to null (unless already changed)
            if ($projeto->getOrientador() === $this) {
                $projeto->setOrientador(null);
            }
        }

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id"=>$this->getId(),
            "nome"=>$this->getNome(),
            "projetos"=>$this->getProjetos()
        ];
    }
}
