<?php
namespace FacebookIntegrationTest;

use Facebook;
use FacebookIntegration\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \FacebookIntegration\Client
     */
    private $client;

    public function setUp()
    {
        $facebook =  new Facebook(array(
            'appId'  => FACEBOOK_APP_ID,
            'secret' => FACEBOOK_APP_SECRET,
        ));
        $this->client = new Client($facebook);
    }

    public function testGetAccessToken()
    {
        $token = $this->client->getAccessToken();
        $this->assertNotNull($token);
    }

    /**
     * @dataProvider searchProvider
     */
    public function testSearch($type)
    {
        $response = $this->client->search('phpunit', $type);
        $this->assertNotNull($response);
    }

    public function searchProvider()
    {
        return array(
            array(Client::TYPE_POST),
            array(Client::TYPE_PAGE),
        );
    }

    public function testSearchPageMock()
    {
        $facebook  = $this->getMockBuilder('\Facebook')
            ->setConstructorArgs(array(array(
            'appId'  => FACEBOOK_APP_ID,
            'secret' => FACEBOOK_APP_SECRET,
            )))
            ->setMethods(array('makeRequest'))
            ->getMock();

        $facebook->expects($this->once())
            ->method('makeRequest')
            ->will(
                $this->returnValue(
                    file_get_contents(dirname(__FILE__) . '/../messages/facebook_search.json')
                )
            );

        $client = new Client($facebook);
        $response = $client->search('phpunit', Client::TYPE_POST);
        $this->assertNotNull($response);
    }
}
