<?php

class InvoiceManager
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function loadInvoice($invoiceId)
    {
        $sql = 'SELECT * FROM invoice where invoice_id = :invoice_id';
        $stm = $this->db->prepare($sql);
        $stm->execute(array(':invoice_id' => $invoiceId));
        $stm->setFetchMode(PDO::FETCH_CLASS, 'Invoice');
        $invoice = $stm->fetch();

        $sql = "SELECT * FROM invoice_item where invoice_id = :invoice_id";
        $stm = $this->db->prepare($sql);
        $stm->execute(array(':invoice_id' => $invoiceId));
        $stm->setFetchMode(PDO::FETCH_CLASS, 'InvoiceItem');

        while ($invoiceItem = $stm->fetch())
        {
            $invoice->addInvoiceItem($invoiceItem);
        }

        return $invoice;
    }

    public function raiseInvoice(Invoice $invoice, Customer $customer, array $productsArray)
    {
        $invoice->customer_id = $customer->customer_id;
        $invoice->status_id = Invoice::STATUS_ISSUED;
        $invoice->date_created = new DateTime();

        foreach ($productsArray as $productItem)
        {
            $product = $productItem['product'];
            $quantity = $productItem['quantity'];

            $invoiceItem = new InvoiceItem();
            $invoiceItem->product_id = $product->product_id;
            $invoiceItem->quantity = $quantity;
            $invoiceItem->price = $product->price;

            $invoice->addInvoiceItem($invoiceItem);
        }

        $invoice->setTotals();
        return $this->storeInvoice($invoice);
    }

    protected function storeInvoice(Invoice $invoice)
    {
        $sql = "INSERT INTO invoice (status_id, customer_id, price_total, date_created)
                    VALUES (:status_id, :customer_id, :price_total, :date_created)";
        $stm = $this->db->prepare($sql);

        $stm->execute(array(':status_id' => $invoice->status_id,
            ':customer_id' => $invoice->customer_id,
            ':price_total' => $invoice->price_total,
            ':date_created' => $invoice->date_created->format("Y-m-d H:i:s")));

        $invoiceId = $this->db->lastInsertId();
        if (!$invoiceId) throw new Exception('Invoice not saved');
        $invoice->invoice_id = $invoiceId;

        foreach ($invoice->invoiceItems as $invoiceItem)
        {
            $invoiceItem->invoice_id = $invoiceId;

            $sql = "INSERT INTO invoice_item (invoice_id, product_id, quantity, price)
                    VALUES (:invoice_id, :product_id, :quantity, :price)";
            $stm = $this->db->prepare($sql);

            $stm->execute(array(':invoice_id' => $invoiceItem->invoice_id,
                ':product_id' => $invoiceItem->product_id,
                ':quantity' => $invoiceItem->quantity, ':price' => $invoiceItem->price));
        }

        return $invoice;
    }
}