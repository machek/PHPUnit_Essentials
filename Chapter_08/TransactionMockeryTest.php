<?php

class TestTransactionMock extends PHPUnit_Framework_TestCase
{
    private $data;

    public function setUp()
    {
        $this->data = array('userId' => 1, 'items' => array('item' => array('id' => 1, 'quantity' => 99)));
    }

    public function tearDown()
    {
        \Mockery::close();
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

    public function testPrepareXMLRequest()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('HttpClient', array(), array('http://localhost'));
        $transaction = new Transaction($logger, $client, $this->data);

        $xmlRequest = $transaction->prepareXMLRequest();
        $request = new SimpleXMLElement($xmlRequest);
        $item = $request->items->item[0];

        $this->assertEquals("1", $request['userId']);
        $this->assertEquals("1", $item['id']);
        $this->assertEquals("99", $item['quantity']);

        return $xmlRequest;

    }

    /**
     * @depends testPrepareXMLRequest
     */
    public function testSendRequest($xmlRequest)
    {
        $logger = \Mockery::mock('ILogger');
        $logger->shouldReceive('log')
            ->once()
            ->with(\Mockery::mustBe($xmlRequest), \Mockery::type('integer'))
            ->andReturn(true);

        $client = \Mockery::mock('HttpClient[send,setRequest]', array('http://localhost'));
        $client->shouldReceive('send')
            ->once()
            ->andReturn(true);

        $client->shouldReceive('setRequest')
            ->once()
            ->with(\Mockery::mustBe($xmlRequest));

        $transaction = new Transaction($logger, $client, $this->data);

        $this->assertFalse($transaction->wasSent());
        $this->assertTrue($transaction->sendRequest());
        $this->assertTrue($transaction->wasSent());
    }
}
