<?php

require_once '../vendor/autoload.php';

use DoctrineExtensions\PHPUnit\OrmTestCase,
    Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Tools\SchemaTool;

class InvoiceManagerDoctrineTest extends OrmTestCase
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected static $em = null;

    public static function setUpBeforeClass()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src"), true, null, null, false);

        $connectionOptions = array('driver' => 'pdo_sqlite', 'memory' => true);

        // obtaining the entity manager
        self::$em = EntityManager::create($connectionOptions, $config);

        $schemaTool = new SchemaTool(self::$em);

        $cmf = self::$em->getMetadataFactory();
        $classes = $cmf->getAllMetadata();

        $schemaTool->dropDatabase();
        $schemaTool->createSchema($classes);

    }

    protected function tearDown()
    {
        self::$em->clear();
        parent::tearDown();
    }

    protected function createEntityManager()
    {
        return self::$em;
    }

    protected function getDataSet()
    {
        return $this->createFlatXmlDataSet(__DIR__ . "/../../dataset.xml");
    }

    public function testLoadInvoice()
    {
        $invoiceManager = new \InvoiceManagerDoctrine(self::$em);
        $invoice = $invoiceManager->loadInvoice(1);

        $this->assertEquals(1, $invoice->getInvoiceId());
        $this->assertEquals(1, $invoice->getCustomer()->getCustomerId());
        $this->assertEquals(100, $invoice->getPriceTotal());

        $invoiceItems = $invoice->getInvoiceItem();

        $this->assertEquals(100, $invoiceItems[0]->getPrice());
        $this->assertEquals(1, $invoiceItems[0]->getProduct()->getProductId());
    }

    public function testRaiseInvoice()
    {
        $invoiceManager = new \InvoiceManagerDoctrine(self::$em);

        $product = self::$em->find('\MyEntity\Product', 1);

        $customer = self::$em->find('\MyEntity\Customer', 1);
        $status = self::$em->find('\MyEntity\InvoiceStatus', 1);

        $invoice = new \MyEntity\Invoice();
        $invoiceManager->raiseInvoice($invoice, $customer,
            array(array('product' => $product, 'quantity' => 2)), $status);

        $this->assertEquals(20, $invoice->getPriceTotal());

        $invoiceFromDB = $invoiceManager->loadInvoice($invoice->getInvoiceId());

        $this->assertEquals($invoice, $invoiceFromDB);
    }
}
