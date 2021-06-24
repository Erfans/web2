<?php

namespace App\Entity;

use App\Model\SalableInterface;
use App\Repository\SalableRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=SalableRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"book" = "Book", "magazine" = "Magazine", "salable" = "Salable"})
 */
class Salable implements SalableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/^[A-Za-z0-9 ]+$/")
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity=BookStore::class, inversedBy="salables")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $bookStore;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="float", nullable=true)
     * @Gedmo\Versioned
     */
    protected $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $priceWithTax;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;



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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBookStore(): ?BookStore
    {
        return $this->bookStore;
    }

    public function setBookStore(?BookStore $bookStore): self
    {
        $this->bookStore = $bookStore;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceWithTax(): ?float
    {
        return $this->priceWithTax;
    }

    public function setPriceWithTax(?float $priceWithTax): self
    {
        $this->priceWithTax = $priceWithTax;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setPriceWithTax($this->getPrice() * (100 + SalableInterface::TAX_PERCENTAGE));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setPriceWithTax($this->getPrice() * (100 + SalableInterface::TAX_PERCENTAGE));
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @param $type
     * @return bool
     */
    public function isTypeOf($type)
    {
        switch ($type) {
            case 'book':
                return $this instanceof Book;
            case 'magazine':
                return $this instanceof Magazine;
            case 'salable':
                return $this instanceof Salable;
            default:
                throw new \RuntimeException('the type is invalid. type: ' . $type);
        }
    }

}
