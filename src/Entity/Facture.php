<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
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
     * @ORM\Column(type="string", length=250)
     */
    private $cheminFic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bien", inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

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

    public function getCheminFic(): ?string
    {
        return $this->cheminFic;
    }

    public function setCheminFic(string $cheminFic): self
    {
        $this->cheminFic = $cheminFic;

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

    public function __toString(){
      return $this->libelle;
    }
}
