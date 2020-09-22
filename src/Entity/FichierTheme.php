<?php

namespace App\Entity;

use App\Repository\FichierThemeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichierThemeRepository::class)
 */
class FichierTheme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Fichier::class, inversedBy="y")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fichier_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichierId(): ?Fichier
    {
        return $this->fichier_id;
    }

    public function setFichierId(?Fichier $fichier_id): self
    {
        $this->fichier_id = $fichier_id;

        return $this;
    }
}
