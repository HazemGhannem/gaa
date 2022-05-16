<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idEvenement;



    /**
     * @ORM\Column(type="integer")
     *  @Assert\NotBlank(message="Champ vide")
     */
    private $idOrganisateur;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Champ vide")
     */
    private $titre;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Champ vide")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Champ vide")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255,name="heure")
     * @Assert\NotBlank(message="Champ vide")
     */
    private $heure;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ vide")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ vide")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ vide")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ vide")
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")

     */
    private $approuver;

    /**
     * @ORM\Column(type="integer")

     */
    private $nombreVus;

    /**
     * @ORM\Column(type="integer")

     */
    private $nombreParticipants;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Champ vide")
     */
    private $nombreMax;



    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
    }

    public function setIdEvenement(int $idEvenement): self
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }

    public function getIdOrganisateur(): ?int
    {
        return $this->idOrganisateur;
    }

    public function setIdOrganisateur(int $idOrganisateur): self
    {
        $this->idOrganisateur = $idOrganisateur;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getApprouver(): ?bool
    {
        return $this->approuver;
    }

    public function setApprouver($approuver): self
    {
        $this->approuver = $approuver;

        return $this;
    }

    public function getNombreVus(): ?int
    {
        return $this->nombreVus;
    }

    public function setNombreVus(int $nombreVus): self
    {
        $this->nombreVus = $nombreVus;

        return $this;
    }

    public function getNombreParticipants(): ?int
    {
        return $this->nombreParticipants;
    }

    public function setNombreParticipants(int $nombreParticipants): self
    {
        $this->nombreParticipants = $nombreParticipants;

        return $this;
    }
    public function getNombreMax(): ?int
    {
        return $this->nombreMax;
    }

    public function setNombreMax(int $nombreMax): self
    {
        $this->nombreMax = $nombreMax;

        return $this;
    }
}
