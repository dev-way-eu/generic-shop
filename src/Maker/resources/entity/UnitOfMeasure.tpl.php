<?php

namespace Devway\GenericShop\Maker\resources\entity;

use Devway\GenericShop\Maker\resources\repository\UnitOfMeasureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitOfMeasureRepository::class)]
class UnitOfMeasure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $abbreviation = null;

    /**
     * @var Collection<int, BaseProduct>
     */
    #[ORM\OneToMany(targetEntity: BaseProduct::class, mappedBy: 'unitOfMeasure')]
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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

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
            $baseProduct->setUnitOfMeasure($this);
        }

        return $this;
    }

    public function removeBaseProduct(BaseProduct $baseProduct): static
    {
        if ($this->baseProducts->removeElement($baseProduct)) {
            // set the owning side to null (unless already changed)
            if ($baseProduct->getUnitOfMeasure() === $this) {
                $baseProduct->setUnitOfMeasure(null);
            }
        }

        return $this;
    }
}
