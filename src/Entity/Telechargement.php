<?php

namespace App\Entity;

use App\Repository\TelechargementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TelechargementRepository::class)
 */
class Telechargement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb;

    /**
     * @ORM\ManyToOne(targetEntity=Fichier::class, inversedBy="telechargements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fichier_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
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
