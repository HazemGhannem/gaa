<?php

namespace App\Entity;

use App\Repository\ParticipationEveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;
/**
 * @ORM\Entity(repositoryClass=ParticipationEveRepository::class)
 */
class ParticipationEve
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idParticipation;

    /**
     * @ORM\Column(type="integer")
     */
    private $idEvenement;

    /**
     * @ORM\Column(type="integer")
     */
    private $idParticipant;

    public function getIdParticipation(): ?int
    {
        return $this->idParticipation;
    }

    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
    }

    public function setIdEvenement(int $idEvenement): self
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }

    public function getIdParticipant(): ?int
    {
        return $this->idParticipant;
    }

    public function setIdParticipant(int $idParticipant): self
    {
        $this->idParticipant = $idParticipant;

        return $this;
    }
}
