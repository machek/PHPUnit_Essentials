<?php

use Doctrine\ORM\EntityManager;

class InvoiceManagerDoctrine
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param  Customer $customer
     * @param  array    $productsArray
     * @return mixed
     */
    public function raiseInvoice(MyEntity\Invoice $invoice, MyEntity\Customer $customer, array $productsArray, MyEntity\InvoiceStatus $invoiceStatus)
    {
        $invoice->setCustomer($customer);
        $invoice->setStatus($invoiceStatus);
        $invoice->setDateCreated(new DateTime());

        foreach ($productsArray as $productItem)
        {
            $product = $productItem['product'];
            $quantity = $productItem['quantity'];

            $invoiceItem = new MyEntity\InvoiceItem();
            $invoiceItem->setProduct($product);
            $invoiceItem->setQuantity($quantity);
            $invoiceItem->setPrice($product->getPrice());
            $invoice->addInvoiceItem($invoiceItem);
        }

        $invoice->setTotals();
        return $this->storeInvoice($invoice);
    }

    /**
     * @param $invoiceId
     * @return \MyEntity\Invoice
     */
    public function loadInvoice($invoiceId)
    {
        return $this->em->find('\MyEntity\Invoice',$invoiceId);
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function storeInvoice(MyEntity\Invoice $invoice)
    {
            foreach($invoice->getInvoiceItem() as $item)
            {
                $this->em->persist($item);
            }

            $this->em->persist($invoice);
            $this->em->flush();
    }
}
