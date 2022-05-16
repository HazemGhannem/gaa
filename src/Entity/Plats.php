<?php

namespace App\Entity;

use App\Repository\PlatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Restaurants;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=PlatsRepository::class)
 */
class Plats
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_plat",type="integer")
     */
    private $id_plat;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurants::class,cascade={"persist"})
     * @ORM\JoinColumn(name="id_resto",referencedColumnName="id_resto",nullable=false)
     */
    private $restoId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="composition est obligatoire")
     * @Assert\Length(min =20 ,minMessage="Verifier Taille composition")
     */
    private $composition;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Prix est obligatoire")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Type est obligatoire")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Photo est obligatoire")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=ReservationPlats::class, mappedBy="platId",cascade={"remove"}, orphanRemoval=true )
     */
    private $reservationPlats;

    public function __construct()
    {
        $this->reservationPlats = new ArrayCollection();
    }





    public function getId_Plat(): ?int
    {
        return $this->id_plat;
    }

    public function getIdPlat(): ?int
    {
        return $this->id_plat;
    }

    public function setIdPlat(int $id): ?self
    {
        $this->id_plat=$id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
    public function getRestoId(): ?Restaurants
    {
        return $this->restoId;
    }

    public function setRestoId(?Restaurants $restoId): self
    {
        $this->restoId = $restoId;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getRestoId();
    }

    /**
     * @return Collection|ReservationPlats[]
     */
    public function getReservationPlats(): Collection
    {
        return $this->reservationPlats;
    }





}
