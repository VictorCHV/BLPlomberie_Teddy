<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Worksite::class)]
    private Collection $worksites;

    public function __construct()
    {
        $this->worksites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Worksite>
     */
    public function getWorksites(): Collection
    {
        return $this->worksites;
    }

    public function addWorksite(Worksite $worksite): self
    {
        if (!$this->worksites->contains($worksite)) {
            $this->worksites->add($worksite);
            $worksite->setCategory($this);
        }

        return $this;
    }

    public function removeWorksite(Worksite $worksite): self
    {
        if ($this->worksites->removeElement($worksite)) {
            // set the owning side to null (unless already changed)
            if ($worksite->getCategory() === $this) {
                $worksite->setCategory(null);
            }
        }

        return $this;
    }
}
