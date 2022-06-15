<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Le nom du matériel est obligatoire')]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Le nom du matériel doit faire au moins {{ limit }} caractère', maxMessage: 'Le nom du matériel doit faire maximum {{ limit }} caractères')]
    private $name;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Le prix du matériel est obligatoire')]
    #[Assert\GreaterThan(0, message: 'Le prix du matériel doit être supérieur à 0')]
    private $price;

    #[ORM\OneToMany(mappedBy: 'materiel', targetEntity: Lien::class, orphanRemoval: true)]
    private $lienClient;

    public function __construct()
    {
        $this->lienClient = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Lien>
     */
    public function getLienClient(): Collection
    {
        return $this->lienClient;
    }

    public function addLienClient(Lien $lienClient): self
    {
        if (!$this->lienClient->contains($lienClient)) {
            $this->lienClient[] = $lienClient;
            $lienClient->setMateriel($this);
        }

        return $this;
    }

    public function removeLienClient(Lien $lienClient): self
    {
        if ($this->lienClient->removeElement($lienClient)) {
            // set the owning side to null (unless already changed)
            if ($lienClient->getMateriel() === $this) {
                $lienClient->setMateriel(null);
            }
        }

        return $this;
    }

    public function getPriceEnEuros():float
    {
        return ($this->getPrice()/100);
    }
    public function __toString(): string
    {
        return $this->getName().' ('.number_format($this->getPriceEnEuros(), 2, ' € ', ' ').')';
    }

}
