<?php

class InvoiceManagerTest extends PHPUnit_Framework_TestCase
{
    private $pdoMock;
    private $stmMock;

    public function setUp()
    {
        $this->stmMock = $this->getMock('PDOStatement', array('execute','fetch'));
        $this->stmMock->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));

        $this->pdoMock = $this->getMock('PDOMock', array('prepare','lastInsertId'));
        $this->pdoMock->expects($this->any())
            ->method('prepare')
            ->will($this->returnValue($this->stmMock));
    }

    public function testRaiseInvoice()
    {
        $this->pdoMock->expects($this->once())
            ->method('lastInsertId')
            ->will($this->returnValue(1));

        $invoiceManager = new InvoiceManager($this->pdoMock);

        $product1 = new Product();
        $product1->price = 10;
        $product1->product_id = 1;

        $customer = new Customer();
        $customer->customer_id = 1;

        $invoice = new Invoice();
        $productsArray = array(array('product' => $product1, 'quantity' => 2));
        $invoiceManager->raiseInvoice($invoice, $customer, $productsArray);

        $this->assertEquals(20, $invoice->price_total);
    }

    public function testLoadInvoice()
    {
        $invoice = new Invoice();
        $invoice->invoice_id = 1;
        $invoice->price_total = 100;

        $invoiceItem = new InvoiceItem();
        $invoiceItem->invoice_item_id = 1;
        $invoiceItem->invoice_id = 1;
        $invoiceItem->price = 100;
        $invoiceItem->product_id = 1;

        $this->stmMock->expects($this->at(1))
            ->method('fetch')
            ->will($this->returnValue($invoice));

        $this->stmMock->expects($this->at(3))
            ->method('fetch')
            ->will($this->returnValue($invoiceItem));

        $invoiceManager = new InvoiceManager($this->pdoMock);
        $invoice = $invoiceManager->loadInvoice(1);

        $this->assertEquals(100, $invoice->price_total);
        $this->assertEquals(100, $invoice->invoiceItems[1]->price);
    }
}