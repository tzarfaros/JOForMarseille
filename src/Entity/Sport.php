<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $subcategory = null;

    #[ORM\Column]
    private ?bool $gender = null;

    #[ORM\OneToMany(mappedBy: 'codeSport', targetEntity: Epreuve::class)]
    private Collection $epreuves;

    public function __construct()
    {
        $this->epreuves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubcategory(): ?string
    {
        return $this->subcategory;
    }

    public function setSubcategory(string $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Epreuve>
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreuVe(Epreuve $epreuve): self
    {
        if (!$this->epreuves->contains($epreuve)) {
            $this->epreuves->add($epreuve);
            $epreuve->setCodeSport($this);
        }

        return $this;
    }

    public function removeEpreuVe(Epreuve $epreuve): self
    {
        if ($this->epreuves->removeElement($epreuve)) {
            // set the owning side to null (unless already changed)
            if ($epreuve->getCodeSport() === $this) {
                $epreuve->setCodeSport(null);
            }
        }

        return $this;
    }
}
