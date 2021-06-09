<?php

namespace App\Entity;

use App\Model\TimeInterface;
use App\Model\TimeTrait;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Model\SalableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Book implements SalableInterface, TimeInterface
{
    use TimeTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/^[A-Za-z0-9 ]+$/")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity=BookStore::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookStore;

    /**
     * @Assert\PositiveOrZero
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceWithTax;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="product", orphanRemoval=true)
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
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

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getProduct() === $this) {
                $order->setProduct(null);
            }
        }

        return $this;
    }
}
