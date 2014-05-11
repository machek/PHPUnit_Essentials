<?php

class InvoiceManagerDBTest extends DatasetTest
{
    public function testRaiseInvoice()
    {
        $invoiceManager = new InvoiceManager($this->getConnection()->getConnection());

        $product1 = new Product();
        $product1->price = 10;
        $product1->product_id = 1;

        $customer = new Customer();
        $customer->customer_id = 1;

        $invoice = new Invoice();
        $productsArray = array(array('product' => $product1, 'quantity' => 2));
        $invoiceManager->raiseInvoice($invoice, $customer, $productsArray);

        $invoiceFromDB = $invoiceManager->loadInvoice($invoice->invoice_id);

        $this->assertEquals($invoice->price_total, $invoiceFromDB->price_total);
        $this->assertEquals(count($invoice->invoiceItems), count($invoiceFromDB->invoiceItems));
    }
}