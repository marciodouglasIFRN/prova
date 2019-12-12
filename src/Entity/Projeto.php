<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetoRepository")
 */
class Projeto implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Professor", inversedBy="projetos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orientador;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Aluno", mappedBy="projeto")
     */
    private $bolsistas;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Log", inversedBy="projeto")
     */
    private $log;

    public function __construct()
    {
        $this->bolsistas = new ArrayCollection();
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

    public function getOrientador(): ?Professor
    {
        return $this->orientador;
    }

    public function setOrientador(?Professor $orientador): self
    {
        $this->orientador = $orientador;

        return $this;
    }

    /**
     * @return Collection|Aluno[]
     */
    public function getBolsistas(): Collection
    {
        return $this->bolsistas;
    }

    public function addBolsista(Aluno $bolsista): self
    {
        if (!$this->bolsistas->contains($bolsista)) {
            $this->bolsistas[] = $bolsista;
            $bolsista->setProjeto($this);
        }

        return $this;
    }

    public function removeBolsista(Aluno $bolsista): self
    {
        if ($this->bolsistas->contains($bolsista)) {
            $this->bolsistas->removeElement($bolsista);
            // set the owning side to null (unless already changed)
            if ($bolsista->getProjeto() === $this) {
                $bolsista->setProjeto(null);
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
            "orientador"=>$this->getOrientador(),
            "bolsistas"=>$this->getBolsistas()->getValues(),
            "status"=>$this->getStatus(),

        ];
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLog(): ?Log
    {
        return $this->log;
    }

    public function setLog(?Log $log): self
    {
        $this->log = $log;

        return $this;
    }

}
