<?php

namespace Devway\GenericShop\Maker\resources\entity;

use Devway\GenericShop\Maker\resources\repository\BaseProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaseProductRepository::class)]
class BaseProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $basePrice = null;

    #[ORM\ManyToOne(inversedBy: 'baseProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UnitOfMeasure $unitOfMeasure = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'baseProducts')]
    private Collection $category;

    /**
     * @var Collection<int, BaseProductProperty>
     */
    #[ORM\OneToMany(targetEntity: BaseProductProperty::class, mappedBy: 'baseProduct')]
    private Collection $baseProductProperties;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'baseProduct', orphanRemoval: true)]
    private Collection $products;

    /**
     * @var Collection<int, BaseProductOption>
     */
    #[ORM\OneToMany(targetEntity: BaseProductOption::class, mappedBy: 'baseProduct', orphanRemoval: true)]
    private Collection $baseProductOptions;

    /**
     * @var Collection<int, BaseProductAdditionnalOption>
     */
    #[ORM\OneToMany(targetEntity: BaseProductAdditionnalOption::class, mappedBy: 'baseProduct')]
    private Collection $baseProductAdditionnalOptions;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->baseProductProperties = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->baseProductOptions = new ArrayCollection();
        $this->baseProductAdditionnalOptions = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBasePrice(): ?float
    {
        return $this->basePrice;
    }

    public function setBasePrice(float $basePrice): static
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getUnitOfMeasure(): ?UnitOfMeasure
    {
        return $this->unitOfMeasure;
    }

    public function setUnitOfMeasure(?UnitOfMeasure $unitOfMeasure): static
    {
        $this->unitOfMeasure = $unitOfMeasure;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, BaseProductProperty>
     */
    public function getBaseProductProperties(): Collection
    {
        return $this->baseProductProperties;
    }

    public function addBaseProductProperty(BaseProductProperty $baseProductProperty): static
    {
        if (!$this->baseProductProperties->contains($baseProductProperty)) {
            $this->baseProductProperties->add($baseProductProperty);
            $baseProductProperty->setBaseProduct($this);
        }

        return $this;
    }

    public function removeBaseProductProperty(BaseProductProperty $baseProductProperty): static
    {
        if ($this->baseProductProperties->removeElement($baseProductProperty)) {
            // set the owning side to null (unless already changed)
            if ($baseProductProperty->getBaseProduct() === $this) {
                $baseProductProperty->setBaseProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setBaseProduct($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBaseProduct() === $this) {
                $product->setBaseProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BaseProductOption>
     */
    public function getBaseProductOptions(): Collection
    {
        return $this->baseProductOptions;
    }

    public function addBaseProductOption(BaseProductOption $baseProductOption): static
    {
        if (!$this->baseProductOptions->contains($baseProductOption)) {
            $this->baseProductOptions->add($baseProductOption);
            $baseProductOption->setBaseProduct($this);
        }

        return $this;
    }

    public function removeBaseProductOption(BaseProductOption $baseProductOption): static
    {
        if ($this->baseProductOptions->removeElement($baseProductOption)) {
            // set the owning side to null (unless already changed)
            if ($baseProductOption->getBaseProduct() === $this) {
                $baseProductOption->setBaseProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BaseProductAdditionnalOption>
     */
    public function getBaseProductAdditionnalOptions(): Collection
    {
        return $this->baseProductAdditionnalOptions;
    }

    public function addBaseProductAdditionnalOption(BaseProductAdditionnalOption $baseProductAdditionnalOption): static
    {
        if (!$this->baseProductAdditionnalOptions->contains($baseProductAdditionnalOption)) {
            $this->baseProductAdditionnalOptions->add($baseProductAdditionnalOption);
            $baseProductAdditionnalOption->setBaseProduct($this);
        }

        return $this;
    }

    public function removeBaseProductAdditionnalOption(BaseProductAdditionnalOption $baseProductAdditionnalOption): static
    {
        if ($this->baseProductAdditionnalOptions->removeElement($baseProductAdditionnalOption)) {
            // set the owning side to null (unless already changed)
            if ($baseProductAdditionnalOption->getBaseProduct() === $this) {
                $baseProductAdditionnalOption->setBaseProduct(null);
            }
        }

        return $this;
    }
}
