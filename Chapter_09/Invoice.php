<?php

class Invoice
{
    const STATUS_ISSUED = 1;
    const STATUS_PAID = 2;
    const STATUS_CANCELLED = 3;

    public $invoice_id;
    public $status_id;
    public $customer_id;
    public $price_total;
    public $date_created;
    /**
     * @var InvoiceItem[]
     */
    public $invoiceItems = array();

    public function addInvoiceItem(InvoiceItem $item)
    {
        $this->invoiceItems[$item->product_id] = $item;
    }

    public function removeInvoiceItem(InvoiceItem $item)
    {
        unset($this->invoiceItems[$item->invoice_id]);
    }

    public function setTotals()
    {
        $this->price_total = 0;

        foreach ($this->invoiceItems as $invoiceItem)
        {
            $this->price_total += $invoiceItem->price * $invoiceItem->quantity;
        }
    }
}
