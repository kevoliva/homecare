<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BienRepository")
 */
class Bien
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="date")
     */
    private $dateConstruct;

    /**
     * @ORM\Column(type="integer")
     */
    private $surface;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proprietaire", inversedBy="biens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprietaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Autorisation", mappedBy="bien")
     */
    private $autorisations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plan", mappedBy="bien")
     */
    private $plans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Facture", mappedBy="bien")
     */
    private $factures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alerte", mappedBy="bien")
     */
    private $alertes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Intervention", mappedBy="bien")
     */
    private $interventions;

    public function __construct()
    {
        $this->autorisations = new ArrayCollection();
        $this->plans = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->alertes = new ArrayCollection();
        $this->interventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getDateConstruct(): ?\DateTimeInterface
    {
        return $this->dateConstruct;
    }

    public function setDateConstruct(\DateTimeInterface $dateConstruct): self
    {
        $this->dateConstruct = $dateConstruct;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getProprietaire(): ?Proprietaire
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Proprietaire $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

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
            $autorisation->setBien($this);
        }

        return $this;
    }

    public function removeAutorisation(Autorisation $autorisation): self
    {
        if ($this->autorisations->contains($autorisation)) {
            $this->autorisations->removeElement($autorisation);
            // set the owning side to null (unless already changed)
            if ($autorisation->getBien() === $this) {
                $autorisation->setBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Plan[]
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): self
    {
        if (!$this->plans->contains($plan)) {
            $this->plans[] = $plan;
            $plan->setBien($this);
        }

        return $this;
    }

    public function removePlan(Plan $plan): self
    {
        if ($this->plans->contains($plan)) {
            $this->plans->removeElement($plan);
            // set the owning side to null (unless already changed)
            if ($plan->getBien() === $this) {
                $plan->setBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setBien($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->contains($facture)) {
            $this->factures->removeElement($facture);
            // set the owning side to null (unless already changed)
            if ($facture->getBien() === $this) {
                $facture->setBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Alerte[]
     */
    public function getAlertes(): Collection
    {
        return $this->alertes;
    }

    public function addAlerte(Alerte $alerte): self
    {
        if (!$this->alertes->contains($alerte)) {
            $this->alertes[] = $alerte;
            $alerte->setBien($this);
        }

        return $this;
    }

    public function removeAlerte(Alerte $alerte): self
    {
        if ($this->alertes->contains($alerte)) {
            $this->alertes->removeElement($alerte);
            // set the owning side to null (unless already changed)
            if ($alerte->getBien() === $this) {
                $alerte->setBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Intervention[]
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions[] = $intervention;
            $intervention->setBien($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->contains($intervention)) {
            $this->interventions->removeElement($intervention);
            // set the owning side to null (unless already changed)
            if ($intervention->getBien() === $this) {
                $intervention->setBien(null);
            }
        }

        return $this;
    }

    public function __toString(){
      return $this->adresse;
    }
}
