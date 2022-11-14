<?php

namespace App\Entity;

use App\Repository\EpreuveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
class Epreuve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\ManyToMany(targetEntity: Sportif::class, mappedBy: 'epreuves')]
    private Collection $sportifs;

    #[ORM\ManyToOne(inversedBy: 'epreuves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sport $codeSport = null;

    #[ORM\ManyToMany(targetEntity: Athlete::class, mappedBy: 'epreuves')]
    private Collection $athletes;

    public function __construct()
    {
        $this->sportifs = new ArrayCollection();
        $this->athletes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Sportif>
     */
    public function getSportifs(): Collection
    {
        return $this->sportifs;
    }

    public function addSportif(Sportif $sportif): self
    {
        if (!$this->sportifs->contains($sportif)) {
            $this->sportifs->add($sportif);
            $sportif->addEpreufe($this);
        }

        return $this;
    }

    public function removeSportif(Sportif $sportif): self
    {
        if ($this->sportifs->removeElement($sportif)) {
            $sportif->removeEpreufe($this);
        }

        return $this;
    }

    public function getCodeSport(): ?Sport
    {
        return $this->codeSport;
    }

    public function setCodeSport(?Sport $codeSport): self
    {
        $this->codeSport = $codeSport;

        return $this;
    }

    /**
     * @return Collection<int, Athlete>
     */
    public function getAthletes(): Collection
    {
        return $this->athletes;
    }

    public function addAthlete(Athlete $athlete): self
    {
        if (!$this->athletes->contains($athlete)) {
            $this->athletes->add($athlete);
            $athlete->addEpreufe($this);
        }

        return $this;
    }

    public function removeAthlete(Athlete $athlete): self
    {
        if ($this->athletes->removeElement($athlete)) {
            $athlete->removeEpreufe($this);
        }

        return $this;
    }
}
