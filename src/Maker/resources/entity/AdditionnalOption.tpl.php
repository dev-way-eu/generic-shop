<?php

namespace Devway\GenericShop\Maker\resources\entity;

use Devway\GenericShop\Maker\resources\repository\AdditionnalOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdditionnalOptionRepository::class)]
class AdditionnalOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, BaseProductAdditionnalOption>
     */
    #[ORM\OneToMany(targetEntity: BaseProductAdditionnalOption::class, mappedBy: 'additionnalOption')]
    private Collection $baseProductAdditionnalOptions;

    public function __construct()
    {
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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
            $baseProductAdditionnalOption->setAdditionnalOption($this);
        }

        return $this;
    }

    public function removeBaseProductAdditionnalOption(BaseProductAdditionnalOption $baseProductAdditionnalOption): static
    {
        if ($this->baseProductAdditionnalOptions->removeElement($baseProductAdditionnalOption)) {
            // set the owning side to null (unless already changed)
            if ($baseProductAdditionnalOption->getAdditionnalOption() === $this) {
                $baseProductAdditionnalOption->setAdditionnalOption(null);
            }
        }

        return $this;
    }
}
