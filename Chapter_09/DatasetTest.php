<?php
class DatasetTest extends PHPUnit_Extensions_Database_TestCase
{
    protected $connection = null;

    public function getDataSet()
    {
        return $this->createFlatXmlDataSet('dataset.xml');
    }

    protected function setUp()
    {
        $conn=$this->getConnection();
        $conn->getConnection()->query("set foreign_key_checks=0");
        parent::setUp();
        $conn->getConnection()->query("set foreign_key_checks=1");
    }

    protected function getConnection()
    {
        if ($this->connection === null)
        {
            $connectionString = $GLOBALS['DB_DRIVER'].':host='.$GLOBALS['DB_HOST'].
                ';dbname='.$GLOBALS['DB_DATABASE'];
            $this->connection = $this->createDefaultDBConnection(new PDO($connectionString,
                $GLOBALS['DB_USER'],$GLOBALS['DB_PASSWORD']));
        }

        return $this->connection;
    }

    public function testConsumer()
    {
        $stm = $this->getConnection()->getConnection()->prepare("select * from customer where customer_id = :customer_id");

        $stm->execute(array('customer_id' => 2));
        $result = $stm->fetch();

        $this->assertEquals("jenny.smith@localhost", $result['email']);

        $dbTable = $this->getConnection()->createQueryTable(
            'customer', 'SELECT * FROM customer'
        );

        $datasetTable = $this->getDataSet()
            ->getTable("customer");

        $this->assertTablesEqual($dbTable, $datasetTable);
    }

    public function testInvoice()
    {
        $dataSet = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $dataSet->addTable('customer');
        $dataSet->addTable('product');
        $dataSet->addTable('invoice');
        $dataSet->addTable('invoice_item');
        $dataSet->addTable('invoice_status');
        $expectedDataSet = $this->getDataSet();

        $this->assertDataSetsEqual($expectedDataSet, $dataSet);
    }
}