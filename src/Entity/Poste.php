<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosteRepository::class)
 */
class Poste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Salarie::class, mappedBy="poste", orphanRemoval=true)
     */
    private $salaries;

    /**
     * @return Collection|Salarie[]
     */
    public function getSalaries(): Collection
    {
        return $this->salaries;
    }

    public function addSalary(Salarie $salary): self
    {
        if (!$this->salaries->contains($salary)) {
            $this->salaries[] = $salary;
            $salary->setPoste($this);
        }

        return $this;
    }

    public function removeSalary(Salarie $salary): self
    {
        if ($this->salaries->removeElement($salary)) {
            // set the owning side to null (unless already changed)
            if ($salary->getPoste() === $this) {
                $salary->setPoste(null);
            }
        }

        return $this;
    }


    public function __construct()
    {
        $this->salaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
