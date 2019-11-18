<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneFraisHorsForfaitRepository")
 */
class LigneFraisHorsForfait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visiteur", inversedBy="ligneFraisHorsForfaits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idVisiteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FicheFrais", inversedBy="ligneFraisHorsForfaits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mois;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVisiteur(): ?Visiteur
    {
        return $this->idVisiteur;
    }

    public function setIdVisiteur(?Visiteur $idVisiteur): self
    {
        $this->idVisiteur = $idVisiteur;

        return $this;
    }

    public function getMois(): ?FicheFrais
    {
        return $this->mois;
    }

    public function setMois(?FicheFrais $mois): self
    {
        $this->mois = $mois;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
