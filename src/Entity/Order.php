<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *    collectionOperations={"get", "post"},
 *    itemOperations={"get"},
 *    normalizationContext={"groups"={"order:read"}},
 *    denormalizationContext={"groups"={"order:write"}}
 * )
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @Groups({"order:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"order:read", "order:write"})
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"order:read", "order:write"})
     */
    private $comment;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }


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
}
