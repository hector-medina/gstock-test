<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ApiResource(
 *    collectionOperations={"get", "post"},
 *    itemOperations={"get"},
 *    normalizationContext={"groups"={"orderItem:read"}},
 *    denormalizationContext={"groups"={"orderItem:write"}}
 * )
 * @ORM\Entity(repositoryClass=OrderItemRepository::class)
 */
class OrderItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"orderItem:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"orderItem:read", "orderItem:write"})
     */
    private $product;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"orderItem:read", "orderItem:write"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups({"orderItem:read", "orderItem:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @Groups({"orderItem:read", "orderItem:write"})
     */
    private $discountPercentage;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Groups({"orderItem:read", "orderItem:write"})
     */
    private $tax;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"orderItem:read", "orderItem:write"})
     */
    private $parentOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountPercentage(): ?string
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?string $discountPercentage): self
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }
    /**
    * @SerializedName("taxPercentage")
    */
    public function getTax(): ?string
    {
        return $this->tax;
    }

    public function setTax(string $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getParentOrder(): ?Order
    {
        return $this->parentOrder;
    }

    public function setParentOrder(?Order $parentOrder): self
    {
        $this->parentOrder = $parentOrder;

        return $this;
    }

    /**
    * This is the baseTax (base imponible), it is calculated based on
    * price per unit multiplied by the quantity.
    *
    * @Groups({"orderItem:read"})
    */
    public function getBaseTax(): string
    {
        return strval(round($this->price * $this->quantity, 2));
    }

    /**
    * Dicount amount based on base tax and discountPercentage.
    *
    * @Groups({"orderItem:read"})
    */
    public function getDiscountAmount(): string
    {
        $taxBase = floatVal($this->getBaseTax());
        return strval(round($taxBase * ($this->discountPercentage/100), 2));
    }

    /**
    * Tax amount calculated with base tax, discount and tax.
    *
    * @Groups({"orderItem:read"})
    */
    public function getTaxAmount(): string
    {
        $taxBase = floatVal($this->getBaseTax());
        $discountAmount = floatVal($this->getDiscountAmount());
        return strval(round(($taxBase - $discountAmount)*($this->tax/100),2));
    }

    /**
    * Total paid by the customer.
    *
    * @Groups({"orderItem:read"})
    */
    public function getTotal(): string
    {
        $taxBase = floatVal($this->getBaseTax());
        $discountAmount = floatVal($this->getDiscountAmount());
        $taxAmount = floatVal($this->getTaxAmount());
        return strval(round($taxBase - $discountAmount + $taxAmount,2));
    }


}
