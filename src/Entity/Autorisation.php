<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AutorisationRepository")
 */
class Autorisation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $plan;

    /**
     * @ORM\Column(type="boolean")
     */
    private $facture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $intervention;

    /**
     * @ORM\Column(type="boolean")
     */
    private $alerte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professionnel", inversedBy="autorisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $professionnel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bien", inversedBy="autorisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlan(): ?bool
    {
        return $this->plan;
    }

    public function setPlan(bool $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function getFacture(): ?bool
    {
        return $this->facture;
    }

    public function setFacture(bool $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getIntervention(): ?bool
    {
        return $this->intervention;
    }

    public function setIntervention(bool $intervention): self
    {
        $this->intervention = $intervention;

        return $this;
    }

    public function getAlerte(): ?bool
    {
        return $this->alerte;
    }

    public function setAlerte(bool $alerte): self
    {
        $this->alerte = $alerte;

        return $this;
    }

    public function getProfessionnel(): ?Professionnel
    {
        return $this->professionnel;
    }

    public function setProfessionnel(?Professionnel $professionnel): self
    {
        $this->professionnel = $professionnel;

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
}
