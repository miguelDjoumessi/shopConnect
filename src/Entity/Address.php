<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $secteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quartier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rue = null;

    /**
     * @var Collection<int, Seller>
     */
    #[ORM\OneToMany(targetEntity: Seller::class, mappedBy: 'address')]
    private Collection $sellers;

    /**
     * @var Collection<int, Shop>
     */
    #[ORM\OneToMany(targetEntity: Shop::class, mappedBy: 'address')]
    private Collection $shops;

    public function __construct()
    {
        $this->sellers = new ArrayCollection();
        $this->shops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): static
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(?string $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * @return Collection<int, Seller>
     */
    public function getSellers(): Collection
    {
        return $this->sellers;
    }

    public function addSeller(Seller $seller): static
    {
        if (!$this->sellers->contains($seller)) {
            $this->sellers->add($seller);
            $seller->setAddress($this);
        }

        return $this;
    }

    public function removeSeller(Seller $seller): static
    {
        if ($this->sellers->removeElement($seller)) {
            // set the owning side to null (unless already changed)
            if ($seller->getAddress() === $this) {
                $seller->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Shop>
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): static
    {
        if (!$this->shops->contains($shop)) {
            $this->shops->add($shop);
            $shop->setAddress($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): static
    {
        if ($this->shops->removeElement($shop)) {
            // set the owning side to null (unless already changed)
            if ($shop->getAddress() === $this) {
                $shop->setAddress(null);
            }
        }

        return $this;
    }
}
