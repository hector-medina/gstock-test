<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;


/**
 * @ApiResource(
 *    collectionOperations={
 *            "get"={"normalization_context"={"groups"={"orders:get:read"}}},
 *            "post"={"denormalization_context"={"groups"={"order:post:write"}}}
 *     },
 *    itemOperations={
 *          "get"={"normalization_context"={"groups"={"order:get:read"}}}
 *    }
 * )
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @Groups({"order:get:read", "orders:get:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"order:get:read", "order:post:write", "orders:get:read"})
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"order:get:read", "order:post:write"})
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="parentOrder")
     * @Groups({"order:get:read"})
     */
    private $orderItems;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->orderItems = new ArrayCollection();
    }

    /**
    * @SerializedName("reference")
    */
    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setParentOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getParentOrder() === $this) {
                $orderItem->setParentOrder(null);
            }
        }

        return $this;
    }
    /**
    * @Groups({"order:get:read", "orders:get:read"})
    */
    public function getSubtotal(): string
    {
      $result = 0.0;
      foreach($this->orderItems as $item){
        $result += floatval($item->getBaseTax());
      }
      return strval($result);
    }


    /**
    * @Groups({"orders:get:read"})
    */
    public function getNumberOfItems(): string
    {
      return strVal(count($this->orderItems));
    }


    /**
    * @Groups({"order:get:read", "orders:get:read"})
    */
    public function getTax(): string
    {
      $result = 0.0;
      foreach($this->orderItems as $item){
        $result += floatval($item->getTaxAmount());
      }
      return strval($result);
    }

    /**
    * @Groups({"order:get:read", "orders:get:read"})
    */
    public function getTotal(): string
    {
      $result = 0.0;
      foreach($this->orderItems as $item){
        $result += floatval($item->getTotal());
      }
      return strval($result);
    }


    /**
    * @Groups({"order:get:read", "orders:get:read"})
    */
    public function getDiscountAmount(): string
    {
      $result = 0.0;
      foreach($this->orderItems as $item){
        $result += floatval($item->getDiscountAmount());
      }
      return strval($result);
    }


    /**
    * @Groups({"orders:get:read"})
    */
    public function getDiscountPercentage(): string
    {
      $discountAmount = floatVal($this->getDiscountAmount());
      $subtotal = floatVal($this->getSubtotal());
      if( $subtotal === 0.0 ) return "0";
      return strval(round( 100 * $discountAmount / $subtotal ,2));
    }


}
