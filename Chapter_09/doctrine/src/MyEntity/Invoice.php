<?php

namespace MyEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @var integer
     *
     * @ORM\Column(name="invoice_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $invoiceId;

    /**
     * @var float
     *
     * @ORM\Column(name="price_total", type="float", nullable=false)
     */
    private $priceTotal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \MyEntity\Customer
     *
     * @ORM\ManyToOne(targetEntity="MyEntity\Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="customer_id")
     * })
     */
    private $customer;

    /**
     * @var \MyEntity\InvoiceStatus
     *
     * @ORM\ManyToOne(targetEntity="MyEntity\InvoiceStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", referencedColumnName="status_id")
     * })
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="MyEntity\InvoiceItem", mappedBy="invoice")
     */
    private $invoiceItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceItem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get invoiceId
     *
     * @return integer
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param float $priceTotal
     */
    public function setPriceTotal($priceTotal)
    {
        $this->priceTotal = $priceTotal;
    }

    /**
     * @return float
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }

    /**
     * Set dateCreated
     *
     * @param  \DateTime $dateCreated
     * @return Invoice
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set customer
     *
     * @param  \MyEntity\Customer $customer
     * @return Invoice
     */
    public function setCustomer(\MyEntity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \MyEntity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set status
     *
     * @param  \MyEntity\InvoiceStatus $status
     * @return Invoice
     */
    public function setStatus(\MyEntity\InvoiceStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \MyEntity\InvoiceStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add invoiceItem
     *
     * @param  \MyEntity\InvoiceItem $invoiceItem
     * @return Invoice
     */
    public function addInvoiceItem(\MyEntity\InvoiceItem $invoiceItem)
    {
        $this->invoiceItem[] = $invoiceItem;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoiceItem()
    {
        return $this->invoiceItem;
    }


    public function setTotals()
    {

        foreach ($this->getInvoiceItem() as $invoiceItem) {
            $this->setPriceTotal( $this->getPriceTotal() + ($invoiceItem->getPrice()) * $invoiceItem->getQuantity());
        }

        return $this;
    }
}
