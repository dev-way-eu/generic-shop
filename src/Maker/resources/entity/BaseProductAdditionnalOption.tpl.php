<?php

namespace Devway\GenericShop\Maker\resources\entity;

use Devway\GenericShop\Maker\resources\repository\BaseProductAdditionnalOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaseProductAdditionnalOptionRepository::class)]
class BaseProductAdditionnalOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'baseProductAdditionnalOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BaseProduct $baseProduct = null;

    #[ORM\ManyToOne(inversedBy: 'baseProductAdditionnalOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AdditionnalOption $additionnalOption = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseProduct(): ?BaseProduct
    {
        return $this->baseProduct;
    }

    public function setBaseProduct(?BaseProduct $baseProduct): static
    {
        $this->baseProduct = $baseProduct;

        return $this;
    }

    public function getAdditionnalOption(): ?AdditionnalOption
    {
        return $this->additionnalOption;
    }

    public function setAdditionnalOption(?AdditionnalOption $additionnalOption): static
    {
        $this->additionnalOption = $additionnalOption;

        return $this;
    }
}
