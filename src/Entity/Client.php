<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $first_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $last_name;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Lien::class, orphanRemoval: true)]
    private $lienMateriel;

    public function __construct()
    {
        $this->lienMateriel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Lien>
     */
    public function getLienMateriel(): Collection
    {
        return $this->lienMateriel;
    }

    public function addLienMateriel(Lien $lienMateriel): self
    {
        if (!$this->lienMateriel->contains($lienMateriel)) {
            $this->lienMateriel[] = $lienMateriel;
            $lienMateriel->setClient($this);
        }

        return $this;
    }

    public function removeLienMateriel(Lien $lienMateriel): self
    {
        if ($this->lienMateriel->removeElement($lienMateriel)) {
            // set the owning side to null (unless already changed)
            if ($lienMateriel->getClient() === $this) {
                $lienMateriel->setClient(null);
            }
        }

        return $this;
    }

    public function getTotalQuantity(): int
    {
        $total = 0;
        foreach($this->getLienMateriel() as $lien) {
            $total += $lien->getQuantity();
        }
        return $total;
    }
    
    // Montant retourné en centimes
    public function getMontantTotal(): int
    {
        $total = 0;
        foreach($this->getLienMateriel() as $lien) {
            $materiel = $lien->getMateriel();
            $total += $lien->getQuantity() * $materiel->getPrice();
        }
        return $total;
    }
    
    public function __toString(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
}
