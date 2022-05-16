<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterielRepository::class)
 */
class Materiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom est vide")
     */
    private $nom_materiel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="description est vide")
     */
    private $description_materiel;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="prix est vide")
     */
    private $prix_materiel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="photo est vide")
     */
    private $photo_materiel;
    /**
     * @ORM\ManyToOne(targetEntity=LocationMateriel::class, inversedBy="materiels")
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMateriel(): ?string
    {
        return $this->nom_materiel;
    }

    public function setNomMateriel(string $nom_materiel): self
    {
        $this->nom_materiel = $nom_materiel;

        return $this;
    }

    public function getDescriptionMateriel(): ?string
    {
        return $this->description_materiel;
    }

    public function setDescriptionMateriel(string $description_materiel): self
    {
        $this->description_materiel = $description_materiel;

        return $this;
    }

    public function getPrixMateriel(): ?float
    {
        return $this->prix_materiel;
    }

    public function setPrixMateriel(float $prix_materiel): self
    {
        $this->prix_materiel = $prix_materiel;

        return $this;
    }

    public function getPhotoMateriel()
    {
        return $this->photo_materiel;
    }

    public function setPhotoMateriel( $photo_materiel)
    {
        $this->photo_materiel = $photo_materiel;

        return $this;
    }


    public function getLocation(): ?LocationMateriel
    {
        return $this->location;
    }

    public function setLocation(?LocationMateriel $location): self
    {
        $this->location = $location;

        return $this;
    }

}
