<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\InvoiceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 * @ApiResource(
 * subresourceOperations={
 *  "api_customers_invoices_get_subresource"={
 *  "normalization_context"={"groups"={"invoices_subresource"}}
 *  }
 * },
 * normalizationContext={"groups"={"invoices_read"}},
 * denormalizationContext={"disable_type_enforcement"=true},
 * attributes={
 *      "pagination_enabled"=true,
 *      "pagination_items_per_page"=20,
 *      "order"={"sentAt": "DESC"}
 *  }
 * )
 * @ApiFilter(OrderFilter::class,properties={"amount", "sentAt"})
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"customers_read","invoices_read","invoices_subresource"})
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="numeric",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"customers_read","invoices_read","invoices_subresource"})
     * @Assert\Type(
     *    type="dateTime",
     * )
     * @Assert\NotBlank
     */
    private $sentAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customers_read","invoices_read","invoices_subresource"})
     * @Assert\NotBlank
     * @Assert\Choice({"PAID", "CANCELLED", "SENT"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"invoices_read"})
     * @Assert\NotBlank
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"customers_read","invoices_read","invoices_subresource"})
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $chrono;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount( $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSentAt(): ?\DateTime
    {
        return $this->sentAt;
    }

    public function setSentAt($sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono( $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
