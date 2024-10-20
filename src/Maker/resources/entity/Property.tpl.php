<?php

namespace Devway\GenericShop\Maker\resources\entity;

use Devway\GenericShop\Maker\resources\repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, BaseProductProperty>
     */
    #[ORM\OneToMany(targetEntity: BaseProductProperty::class, mappedBy: 'property')]
    private Collection $baseProductProperties;

    public function __construct()
    {
        $this->baseProductProperties = new ArrayCollection();
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
            $baseProductProperty->setProperty($this);
        }

        return $this;
    }

    public function removeBaseProductProperty(BaseProductProperty $baseProductProperty): static
    {
        if ($this->baseProductProperties->removeElement($baseProductProperty)) {
            // set the owning side to null (unless already changed)
            if ($baseProductProperty->getProperty() === $this) {
                $baseProductProperty->setProperty(null);
            }
        }

        return $this;
    }
}
