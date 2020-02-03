<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlerteRepository")
 */
class Alerte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     */
    private $laDate;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bien", inversedBy="alertes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Intervention", mappedBy="alerte", cascade={"persist", "remove"})
     */
    private $intervention;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getLaDate(): ?\DateTimeInterface
    {
        return $this->laDate;
    }

    public function setLaDate(\DateTimeInterface $laDate): self
    {
        $this->laDate = $laDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): self
    {
        $this->bien = $bien;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): self
    {
        $this->intervention = $intervention;

        // set (or unset) the owning side of the relation if necessary
        $newAlerte = null === $intervention ? null : $this;
        if ($intervention->getAlerte() !== $newAlerte) {
            $intervention->setAlerte($newAlerte);
        }

        return $this;
    }
}
