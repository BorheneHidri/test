<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0 , nullable:true)]
    private ?string $price = null;

    #[ORM\Column( nullable:true)]
    private ?bool $isAvailable = null;

    /**
     * @var Collection<int, ProductCategoryMembership>
     */
    #[ORM\OneToMany(targetEntity: ProductCategoryMembership::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $ProductCategories;

    public function __construct()
    {
        $this->ProductCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategoryMembership>
     */
    public function getProductCategories(): Collection
    {
        return $this->ProductCategories;
    }

    public function addProductCategory(ProductCategoryMembership $productCategory): static
    {
        if (!$this->ProductCategories->contains($productCategory)) {
            $this->ProductCategories->add($productCategory);
            $productCategory->setProduct($this);
        }

        return $this;
    }

    public function removeProductCategory(ProductCategoryMembership $productCategory): static
    {
        if ($this->ProductCategories->removeElement($productCategory)) {
            // set the owning side to null (unless already changed)
            if ($productCategory->getProduct() === $this) {
                $productCategory->setProduct(null);
            }
        }

        return $this;
    }
}
