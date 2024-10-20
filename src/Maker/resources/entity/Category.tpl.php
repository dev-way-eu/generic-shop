<?php

namespace Devway\GenericShop\Maker\resources\entity;

use Devway\GenericShop\Maker\resources\repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, BaseProduct>
     */
    #[ORM\ManyToMany(targetEntity: BaseProduct::class, mappedBy: 'category')]
    private Collection $baseProducts;

    public function __construct()
    {
        $this->baseProducts = new ArrayCollection();
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

    /**
     * @return Collection<int, BaseProduct>
     */
    public function getBaseProducts(): Collection
    {
        return $this->baseProducts;
    }

    public function addBaseProduct(BaseProduct $baseProduct): static
    {
        if (!$this->baseProducts->contains($baseProduct)) {
            $this->baseProducts->add($baseProduct);
            $baseProduct->addCategory($this);
        }

        return $this;
    }

    public function removeBaseProduct(BaseProduct $baseProduct): static
    {
        if ($this->baseProducts->removeElement($baseProduct)) {
            $baseProduct->removeCategory($this);
        }

        return $this;
    }
}
