<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomexp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomexp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneexp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomrecep;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomrecep;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephonerecep;

    /**
     * @ORM\Column(type="integer")
     */
    private $codeenvoie;

    /**
     * @ORM\Column(type="integer")
     */
    private $montanttotal;

    /**
     * @ORM\Column(type="integer")
     */
    private $cni;

    /**
     * @ORM\Column(type="integer")
     */
    private $envoietarifs;

    /**
     * @ORM\Column(type="integer")
     */
    private $retraittarifs;

    /**
     * @ORM\Column(type="integer")
     */
    private $etattarifs;

    /**
     * @ORM\Column(type="integer")
     */
    private $waritarifs;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantenvoie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomexp(): ?string
    {
        return $this->nomexp;
    }

    public function setNomexp(string $nomexp): self
    {
        $this->nomexp = $nomexp;

        return $this;
    }

    public function getPrenomexp(): ?string
    {
        return $this->prenomexp;
    }

    public function setPrenomexp(string $prenomexp): self
    {
        $this->prenomexp = $prenomexp;

        return $this;
    }

    public function getTelephoneexp(): ?string
    {
        return $this->telephoneexp;
    }

    public function setTelephoneexp(string $telephoneexp): self
    {
        $this->telephoneexp = $telephoneexp;

        return $this;
    }

    public function getNomrecep(): ?string
    {
        return $this->nomrecep;
    }

    public function setNomrecep(string $nomrecep): self
    {
        $this->nomrecep = $nomrecep;

        return $this;
    }

    public function getPrenomrecep(): ?string
    {
        return $this->prenomrecep;
    }

    public function setPrenomrecep(string $prenomrecep): self
    {
        $this->prenomrecep = $prenomrecep;

        return $this;
    }

    public function getTelephonerecep(): ?string
    {
        return $this->telephonerecep;
    }

    public function setTelephonerecep(string $telephonerecep): self
    {
        $this->telephonerecep = $telephonerecep;

        return $this;
    }

    public function getCodeenvoie(): ?int
    {
        return $this->codeenvoie;
    }

    public function setCodeenvoie(int $codeenvoie): self
    {
        $this->codeenvoie = $codeenvoie;

        return $this;
    }

    public function getMontanttotal(): ?int
    {
        return $this->montanttotal;
    }

    public function setMontanttotal(int $montanttotal): self
    {
        $this->montanttotal = $montanttotal;

        return $this;
    }

    public function getCni(): ?int
    {
        return $this->cni;
    }

    public function setCni(int $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getEnvoietarifs(): ?int
    {
        return $this->envoietarifs;
    }

    public function setEnvoietarifs(int $envoietarifs): self
    {
        $this->envoietarifs = $envoietarifs;

        return $this;
    }

    public function getRetraittarifs(): ?int
    {
        return $this->retraittarifs;
    }

    public function setRetraittarifs(int $retraittarifs): self
    {
        $this->retraittarifs = $retraittarifs;

        return $this;
    }

    public function getEtattarifs(): ?int
    {
        return $this->etattarifs;
    }

    public function setEtattarifs(int $etattarifs): self
    {
        $this->etattarifs = $etattarifs;

        return $this;
    }

    public function getWaritarifs(): ?int
    {
        return $this->waritarifs;
    }

    public function setWaritarifs(int $waritarifs): self
    {
        $this->waritarifs = $waritarifs;

        return $this;
    }

    public function getMontantenvoie(): ?int
    {
        return $this->montantenvoie;
    }

    public function setMontantenvoie(int $montantenvoie): self
    {
        $this->montantenvoie = $montantenvoie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
