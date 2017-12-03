<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @var guid
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @Groups({"default"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Groups({"default"})
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="bigint")
     *
     * @Groups({"default"})
     */
    private $price;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserOrder", mappedBy="product")
     */
    private $orders;

    /**
     * @var bool
     *
     * @ORM\Column(name="discount", type="boolean")
     *
     * @Groups({"default"})
     */
    private $discount;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->discount = false;
    }

    /**
     * Get id
     *
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice(float $price)
    {
        $this->price = (int) ($price * 100);

        return $this;
    }

    /**
     * Get price
     *
     * @return null|float
     */
    public function getPrice(): ?float
    {
        return $this->price / 100;
    }

    /**
     * Get orders.
     *
     * @return ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * Set discount.
     *
     * @param bool $discount
     *
     * @return Product
     */
    public function setDiscount(bool $discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return bool
     */
    public function getDiscount(): bool
    {
        return $this->discount;
    }
}

