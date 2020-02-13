<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InterventionRepository")
 */
class Intervention
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
     * @ORM\Column(type="string", length=100)
     */
    private $typeInterv;

    /**
     * @ORM\Column(type="text")
     */
    private $observation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remarque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bien", inversedBy="interventions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Alerte", inversedBy="intervention", cascade={"persist", "remove"})
     */
    private $alerte;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $laDate;

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

    public function getTypeInterv(): ?string
    {
        return $this->typeInterv;
    }

    public function setTypeInterv(string $typeInterv): self
    {
        $this->typeInterv = $typeInterv;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

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

    public function getAlerte(): ?Alerte
    {
        return $this->alerte;
    }

    public function setAlerte(?Alerte $alerte): self
    {
        $this->alerte = $alerte;

        return $this;
    }

    public function __toString(){
      return $this->libelle;
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
}
