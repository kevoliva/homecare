<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionnelRepository")
 */
class Professionnel extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nomEntrep;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Autorisation", mappedBy="professionnel")
     */
    private $autorisations;

    public function __construct()
    {
        $this->autorisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntrep(): ?string
    {
        return $this->nomEntrep;
    }

    public function setNomEntrep(string $nomEntrep): self
    {
        $this->nomEntrep = $nomEntrep;

        return $this;
    }

    /**
     * @return Collection|Autorisation[]
     */
    public function getAutorisations(): Collection
    {
        return $this->autorisations;
    }

    public function addAutorisation(Autorisation $autorisation): self
    {
        if (!$this->autorisations->contains($autorisation)) {
            $this->autorisations[] = $autorisation;
            $autorisation->setProfessionnel($this);
        }

        return $this;
    }

    public function removeAutorisation(Autorisation $autorisation): self
    {
        if ($this->autorisations->contains($autorisation)) {
            $this->autorisations->removeElement($autorisation);
            // set the owning side to null (unless already changed)
            if ($autorisation->getProfessionnel() === $this) {
                $autorisation->setProfessionnel(null);
            }
        }

        return $this;
    }

    public function __toString(){
      return $this->nomEntrep;
    }
}
