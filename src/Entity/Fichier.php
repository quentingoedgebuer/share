<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichierRepository::class)
 */
class Fichier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taille;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="fichiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Telechargement::class, mappedBy="fichier_id")
     */
    private $telechargements;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="utilisateur_id")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity=FichierTheme::class, mappedBy="fichier_id")
     */
    private $y;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $vraiNom;

    public function __construct()
    {
        $this->telechargements = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->y = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;

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

    public function getExtension():?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection|Telechargement[]
     */
    public function getTelechargements(): Collection
    {
        return $this->telechargements;
    }

    public function addTelechargement(Telechargement $telechargement): self
    {
        if (!$this->telechargements->contains($telechargement)) {
            $this->telechargements[] = $telechargement;
            $telechargement->setFichierId($this);
        }

        return $this;
    }

    public function removeTelechargement(Telechargement $telechargement): self
    {
        if ($this->telechargements->contains($telechargement)) {
            $this->telechargements->removeElement($telechargement);
            // set the owning side to null (unless already changed)
            if ($telechargement->getFichierId() === $this) {
                $telechargement->setFichierId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setUtilisateurId($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getUtilisateurId() === $this) {
                $utilisateur->setUtilisateurId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FichierTheme[]
     */
    public function getY(): Collection
    {
        return $this->y;
    }

    public function addY(FichierTheme $y): self
    {
        if (!$this->y->contains($y)) {
            $this->y[] = $y;
            $y->setFichierId($this);
        }

        return $this;
    }

    public function removeY(FichierTheme $y): self
    {
        if ($this->y->contains($y)) {
            $this->y->removeElement($y);
            // set the owning side to null (unless already changed)
            if ($y->getFichierId() === $this) {
                $y->setFichierId(null);
            }
        }

        return $this;
    }

    public function getVraiNom(): ?string
    {
        return $this->vraiNom;
    }

    public function setVraiNom(string $vraiNom): self
    {
        $this->vraiNom = $vraiNom;

        return $this;
    }
}
