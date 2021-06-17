<?php

namespace App\Entity;

use App\Model\TimeTrait;
use App\Repository\BookStoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookStoreRepository::class)
 */
class BookStore
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/^[a-zA-Z]+$/")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Regex(pattern="/^[\d|\s]+$/")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     *
     * @Assert\Email()
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=Salable::class, mappedBy="bookStore", orphanRemoval=true)
     */
    private $salables;

    public function __construct()
    {
        $this->books = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getSalables(): Collection
    {
        return $this->salables;
    }

    public function addSalable(Salable $salable): self
    {
        if (!$this->salables->contains($salable)) {
            $this->salables[] = $salable;
            $salable->setBookStore($this);
        }

        return $this;
    }

    public function removeSalable(Salable $salable): self
    {
        if ($this->salables->removeElement($salable)) {
            // set the owning side to null (unless already changed)
            if ($salable->getBookStore() === $this) {
                $salable->setBookStore(null);
            }
        }

        return $this;
    }


    public function getBooks()
    {
        return $this->salables->filter(function ($salable) {
            return $salable instanceof Book;
        });
    }


    public function getMagazines()
    {
        return $this->salables->filter(function ($salable) {
            return $salable instanceof Magazine;
        });
    }


    public function __toString()
    {
        return $this->getName() . "[" . $this->getEmail() . "]";
    }
}
