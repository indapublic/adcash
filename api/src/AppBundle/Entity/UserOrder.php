<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserOrder
 *
 * @ORM\Table(name="user_orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserOrderRepository")
 */
class UserOrder
{
    /**
     * @var guid
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="orders")
     * @ORM\Column(name="product", type="object")
     */
    private $product;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="bigint")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="bigint")
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    public function __construct()
    {
        $this->dateCreated = new \DateTime("now");
        $this->quantity = 0;
        $this->price = 0;
        $this->total = 0;
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
     * Set user
     *
     * @param User $user
     *
     * @return UserOrder
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set product
     *
     * @param Product $product
     *
     * @return UserOrder
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return null|Product
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return UserOrder
     */
    public function setPrice(float $price)
    {
        $this->price = (int) $price * 100;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price / 100;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return UserOrder
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return null|int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Calculate total.
     *
     * @return UserOrder
     */
    public function calcTotal()
    {
        $this->setTotal($this->getPrice() * $this->getQuantity() * 100);

        return $this;
    }

    /**
     * Set total
     *
     * @param float $total
     *
     * @return UserOrder
     */
    public function setTotal(float $total)
    {
        $this->total = (int) $total * 100;

        return $this;
    }

    /**
     * Get total
     *
     * @return null|float
     */
    public function getTotal(): ?float
    {
        return $this->total / 100;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return UserOrder
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated.
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated->setTimezone(new \DateTimeZone('Asia/Vladivostok'))->format('Y-m-d H:i:s');
    }
}

