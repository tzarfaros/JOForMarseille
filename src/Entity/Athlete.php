<?php

namespace App\Entity;

use App\Repository\AthleteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AthleteRepository::class)]
class Athlete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api_athlete_browse'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api_athlete_browse'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api_athlete_browse'])]
    private ?string $firstname = null;

    #[ORM\Column]
    #[Groups(['api_athlete_browse'])]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api_athlete_browse'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['api_athlete_browse'])]
    private ?bool $gender = null;

    #[ORM\ManyToOne(inversedBy: 'athletes')]
    private ?Delegation $codeDelegation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api_athlete_browse'])]
    private ?string $nationality = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'athletes')]
    private Collection $userLike;

    #[ORM\ManyToMany(targetEntity: Event::class, inversedBy: 'athletes')]
    #[Groups(['api_athlete_browse'])]
    private Collection $events;

    #[ORM\ManyToMany(targetEntity: Epreuve::class, inversedBy: 'athletes')]
    #[Groups(['api_athlete_browse'])]
    private Collection $epreuves;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api_athlete_browse'])]
    private ?string $city = null;

    #[ORM\ManyToMany(targetEntity: Record::class, inversedBy: 'athletes')]
    #[Groups(['api_athlete_browse'])]
    private Collection $records;

    #[ORM\Column(nullable: true)]
    private ?bool $feature = null;

    public function __construct()
    {
        $this->records = new ArrayCollection();
        $this->userLike = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->epreuves = new ArrayCollection();
        $this->feature = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getCodeDelegation(): ?Delegation
    {
        return $this->codeDelegation;
    }

    public function setCodeDelegation(?Delegation $codeDelegation): self
    {
        $this->codeDelegation = $codeDelegation;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection<int, Record>
     */
    public function getRecords(): Collection
    {
        return $this->records;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserLike(): Collection
    {
        return $this->userLike;
    }

    public function addUserLike(User $userLike): self
    {
        if (!$this->userLike->contains($userLike)) {
            $this->userLike->add($userLike);
        }

        return $this;
    }

    public function removeUserLike(User $userLike): self
    {
        $this->userLike->removeElement($userLike);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }

    /**
     * @return Collection<int, Epreuve>
     */
    public function getEpreuves(): Collection
    {
        return $this->epreuves;
    }

    public function addEpreuve(Epreuve $epreuve): self
    {
        if (!$this->epreuves->contains($epreuve)) {
            $this->epreuves->add($epreuve);
        }

        return $this;
    }

    public function removeEpreuve(Epreuve $epreuve): self
    {
        $this->epreuves->removeElement($epreuve);

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function addRecord(Record $record): self
    {
        if (!$this->records->contains($record)) {
            $this->records->add($record);
        }

        return $this;
    }

    public function removeRecord(Record $record): self
    {
        $this->records->removeElement($record);

        return $this;
    }

    public function isFeature(): ?bool
    {
        return $this->feature;
    }

    public function setFeature(?bool $feature): self
    {
        $this->feature = $feature;

        return $this;
    }
}
