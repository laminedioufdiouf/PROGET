<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TarifsRepository")
 */
class Tarifs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $borneinferieur;

    /**
     * @ORM\Column(type="integer")
     */
    private $bornesuperieur;

    /**
     * @ORM\Column(type="integer")
     */
    private $valeurs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorneinferieur(): ?int
    {
        return $this->borneinferieur;
    }

    public function setBorneinferieur(int $borneinferieur): self
    {
        $this->borneinferieur = $borneinferieur;

        return $this;
    }

    public function getBornesuperieur(): ?int
    {
        return $this->bornesuperieur;
    }

    public function setBornesuperieur(int $bornesuperieur): self
    {
        $this->bornesuperieur = $bornesuperieur;

        return $this;
    }

    public function getValeurs(): ?int
    {
        return $this->valeurs;
    }

    public function setValeurs(int $valeurs): self
    {
        $this->valeurs = $valeurs;

        return $this;
    }
}
