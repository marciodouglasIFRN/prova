<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Aluno", mappedBy="log")
     */
    private $aluno;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projeto", mappedBy="log")
     */
    private $projeto;

    public function __construct()
    {
        $this->aluno = new ArrayCollection();
        $this->projeto = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Aluno[]
     */
    public function getAluno(): Collection
    {
        return $this->aluno;
    }

    public function addAluno(Aluno $aluno): self
    {
        if (!$this->aluno->contains($aluno)) {
            $this->aluno[] = $aluno;
            $aluno->setLog($this);
        }

        return $this;
    }

    public function removeAluno(Aluno $aluno): self
    {
        if ($this->aluno->contains($aluno)) {
            $this->aluno->removeElement($aluno);
            // set the owning side to null (unless already changed)
            if ($aluno->getLog() === $this) {
                $aluno->setLog(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Projeto[]
     */
    public function getProjeto(): Collection
    {
        return $this->projeto;
    }

    public function addProjeto(Projeto $projeto): self
    {
        if (!$this->projeto->contains($projeto)) {
            $this->projeto[] = $projeto;
            $projeto->setLog($this);
        }

        return $this;
    }

    public function removeProjeto(Projeto $projeto): self
    {
        if ($this->projeto->contains($projeto)) {
            $this->projeto->removeElement($projeto);
            // set the owning side to null (unless already changed)
            if ($projeto->getLog() === $this) {
                $projeto->setLog(null);
            }
        }

        return $this;
    }
}
