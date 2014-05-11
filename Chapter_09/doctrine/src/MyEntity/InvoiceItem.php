<?php

namespace MyEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceItem
 *
 * @ORM\Table(name="invoice_item")
 * @ORM\Entity
 */
class InvoiceItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="invoice_item_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $invoiceItemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    private $price;

    /**
     * @var \MyEntity\Invoice
     *
     * @ORM\ManyToOne(targetEntity="MyEntity\Invoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_id", referencedColumnName="invoice_id")
     * })
     */
    private $invoice;

    /**
     * @var \MyEntity\Product
     *
     * @ORM\ManyToOne(targetEntity="MyEntity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;

    /**
     * Get invoiceItemId
     *
     * @return integer
     */
    public function getInvoiceItemId()
    {
        return $this->invoiceItemId;
    }

    /**
     * Set quantity
     *
     * @param  integer     $quantity
     * @return InvoiceItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set invoice
     *
     * @param  \MyEntity\Invoice $invoice
     * @return InvoiceItem
     */
    public function setInvoice(\MyEntity\Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \MyEntity\Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set product
     *
     * @param  \MyEntity\Product $product
     * @return InvoiceItem
     */
    public function setProduct(\MyEntity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MyEntity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

}
