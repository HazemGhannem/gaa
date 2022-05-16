<?php

namespace App\Entity;

use App\Repository\RestaurantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=RestaurantsRepository::class)
 */
class Restaurants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id_resto;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="l'adresee est obligatoire")
     * @Assert\Length(min =20 ,minMessage="Verifier L'adresse adresse")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ville est obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=10000)
     * @Assert\NotBlank(message="description est obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="type est obligatoire")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="photo est obligatoire")
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le numero est obligatoire")
     * @Assert\Length(min=8,max=8 ,minMessage="minimum 8",maxMessage="maximum 8")
     */
    private $num_tel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="email est obligatoire")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="note est obligatoire")
     * @Assert\Range(
     *      min = 0,
     *      max = 5,
     *      notInRangeMessage = "Note must be between {{ min }}and {{ max }}",
     * )
     */
    private $note;

    /**
     *
     * @ORM\OneToMany(targetEntity=Plats::class, mappedBy="restoId",cascade={"remove"}, orphanRemoval=true)
     */
    private $plats;

    public function __construct()
    {
        $this->plats = new ArrayCollection();
    }

    public function getId_Resto(): ?int
    {
        return $this->id_resto;
    }
    public function getIdResto(): ?int
    {
        return $this->id_resto;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function setPhoto( $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNum_Tel(): ?int
    {
        return $this->num_tel;
    }
    public function getNumTel(): ?int
    {
        return $this->num_tel;
    }

    public function setNumTel(int $num_tel): self
    {
        $this->num_tel = $num_tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId_Resto();
    }


    /**
     * @return Collection|Plats[]
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plats $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats[] = $plat;
            $plat->setIdPlat($this);
        }

        return $this;
    }

    public function removePlat(Plats $plat): self
    {
        if ($this->plats->removeElement($plat)) {
            // set the owning side to null (unless already changed)
            if ($plat->getIdPlat() === $this) {
                $plat->setIdPlat(null);
            }
        }

        return $this;
    }
}
