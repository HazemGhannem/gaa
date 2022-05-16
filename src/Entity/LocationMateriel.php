<?php

namespace App\Entity;

use App\Repository\LocationMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LocationMaterielRepository::class)
 */
class LocationMateriel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="total est vide")
     */
    private $total_location;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="duree est vide")
     */
    private $duree_location;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="date est vide")
     * @Assert\Expression(
     *     "this.getDateDebutLocation() < this.getDateFinLocation()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     */
    private $date_debut_location;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="date est vide")
     */
    private $date_fin_location;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="adresse est vide")
     */
    private $adresse_locataire_location;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom est vide")
     */
    private $nom_locataire_location;

    /**
     * @ORM\OneToMany(targetEntity=Materiel::class, mappedBy="location",orphanRemoval=true, cascade={"all"})
     */
    private $materiels;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalLocation(): ?float
    {
        return $this->total_location;
    }

    public function setTotalLocation(float $total_location): self
    {
        $this->total_location = $total_location;

        return $this;
    }

    public function getDureeLocation(): ?int
    {
        return $this->duree_location;
    }

    public function setDureeLocation(int $duree_location): self
    {
        $this->duree_location = $duree_location;

        return $this;
    }

    public function getDateDebutLocation(): ?\DateTimeInterface
    {
        return $this->date_debut_location;
    }

    public function setDateDebutLocation(\DateTimeInterface $date_debut_location): self
    {
        $this->date_debut_location = $date_debut_location;

        return $this;
    }

    public function getDateFinLocation(): ?\DateTimeInterface
    {
        return $this->date_fin_location;
    }

    public function setDateFinLocation(\DateTimeInterface $date_fin_location): self
    {
        $this->date_fin_location = $date_fin_location;

        return $this;
    }

    public function getAdresseLocataireLocation(): ?string
    {
        return $this->adresse_locataire_location;
    }

    public function setAdresseLocataireLocation(string $adresse_locataire_location): self
    {
        $this->adresse_locataire_location = $adresse_locataire_location;

        return $this;
    }

    public function getNomLocataireLocation(): ?string
    {
        return $this->nom_locataire_location;
    }

    public function setNomLocataireLocation(string $nom_locataire_location): self
    {
        $this->nom_locataire_location = $nom_locataire_location;

        return $this;
    }

    /**
     * @return Collection|Materiel[]
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): self
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels[] = $materiel;
            $materiel->setLocation($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): self
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getLocation() === $this) {
                $materiel->setLocation(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getId();
    }
}
