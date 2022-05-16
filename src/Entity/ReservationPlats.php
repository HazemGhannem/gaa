<?php

namespace App\Entity;

use App\Repository\ReservationPlatsRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationPlatsRepository::class)
 */
class ReservationPlats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_resPlat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="id_client",referencedColumnName="id",nullable=false)
     */
    private $clientId;

    /**
     * @ORM\ManyToOne(targetEntity=Plats::class)
     * @ORM\JoinColumn(name="id_plat",referencedColumnName="id_plat",nullable=false)
     */
    private $platId;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Quantity est obligatoire")
     */
    private $Quantity;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Date est obligatoire")
     *
     */
    private $dateReservation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */




    public function getIdResPlat(): ?int
    {
        return $this->id_resPlat;
    }

    public function getId_ResPlat(): ?int
    {
        return $this->id_resPlat;
    }
    public function getClientId(): ?User
    {
        return $this->clientId;
    }

    public function setClientId(?User $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getPlatId(): ?Plats
    {
        return $this->platId;
    }


    public function setPlatId(?Plats $platId): self
    {
        $this->platId = $platId;

        return $this;
    }


    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }
}
