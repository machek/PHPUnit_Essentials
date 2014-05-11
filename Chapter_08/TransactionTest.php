<?php

class TestTransaction extends PHPUnit_Framework_TestCase
{
    private $data;

    public function setUp()
    {
        $this->data = array('userId' => 1,
            'items' => array('item' => array('id' => 1, 'quantity' => 99))
        );
    }

    public function testPrepareXMLRequest()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('HttpClient', array(), array('http://localhost'));
        $transaction = new Transaction($logger, $client, $this->data);

        $request = new SimpleXMLElement($transaction->prepareXMLRequest());
        $item = $request->items->item[0];

        $this->assertEquals("1", $request['userId']);
        $this->assertEquals("1", $item['id']);
        $this->assertEquals("99", $item['quantity']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPrepareXMLRequestFail()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('HttpClient', array(), array('http://localhost'));

        $dataMissingUserId = $this->data;
        unset($dataMissingUserId['userId']);

        $transaction = new Transaction($logger, $client, $dataMissingUserId);

        $xmlRequest = $transaction->prepareXMLRequest();
    }

    public function testSendRequest()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('HttpClient', array('send'), array('http://localhost'));

        $client->expects($this->any())
            ->method('send')
            ->will($this->returnValue(true));

        $transaction = new Transaction($logger, $client, $this->data);

        $this->assertFalse($transaction->wasSent());
        $this->assertTrue($transaction->sendRequest());
        $this->assertTrue($transaction->wasSent());
    }

    /**
     *  @requires PHPUnit 4
     */
    public function testSendRequestProxy()
    {
        $logger = new FakeLogger();
        $client = $this->getMockBuilder('HttpClient')
            ->setConstructorArgs(array('http://localhost'))
            ->enableProxyingToOriginalMethods()
            ->getMock();

        $client->expects($this->once())
            ->method('send');

        $transaction = new Transaction($logger, $client, $this->data);

        $this->assertFalse($transaction->wasSent());
        $this->assertTrue($transaction->sendRequest());
        $this->assertTrue($transaction->wasSent());
    }
}