<?php
namespace StackOverflowTest;

use StackOverflow\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group apiCall
     */
    public function testLiveSearch()
    {
        $curlClient = new \CurlClient();
        $client = new Client($curlClient);
        $response = $client->search('phpunit');
        $this->assertNotNull($response);
        $this->assertObjectNotHasAttribute('error_id',$response);
    }

    /**
     * @group apiCall
     */
    public function testLiveSearchError()
    {
        $curlClient = new \CurlClient();
        $client = new Client($curlClient);
        $response = $client->search(NULL);
        $this->assertNotNull($response);
        $this->assertObjectHasAttribute('error_id',$response);
    }

    /**
     * @group mock
     */
    public function testMockSearch()
    {
        $curlClient = $this->getMockBuilder('\CurlClient')
            ->setMethods(array('sendRequest'))
            ->getMock();

        $curlClient->expects($this->once())
            ->method('sendRequest')
            ->will(
                $this->returnValue(
                    json_decode(file_get_contents(dirname(__FILE__) . '/../messages/search.json'))
                )
            );

        $client = new Client($curlClient);
        $response = $client->search('phpunit');
        $this->assertNotNull($response);
        $this->assertObjectNotHasAttribute('error_id',$response);
    }

    /**
     * @group mock
     */
    public function testMockSearchError()
    {
        $curlClient = $this->getMockBuilder('\CurlClient')
            ->setMethods(array('sendRequest'))
            ->getMock();

        $curlClient->expects($this->once())
            ->method('sendRequest')
            ->will(
                $this->returnValue(
                    json_decode(file_get_contents(dirname(__FILE__) . '/../messages/error.json'))
                )
            );

        $client = new Client($curlClient);
        $response = $client->search(NULL);
        $this->assertNotNull($response);
        $this->assertObjectHasAttribute('error_id',$response);
    }
}
