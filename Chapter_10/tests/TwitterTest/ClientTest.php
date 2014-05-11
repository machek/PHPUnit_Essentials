<?php

namespace TwitterTest;

use Mockery;
use Zend\Http;
use ZendService\Twitter;

class ClientTest  extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    protected function stubTwitter($path, $method, $responseFile = null, array $params = null)
    {
        $client = Mockery::mock('ZendOAuth\Client')->shouldIgnoreMissing();

        $client->shouldReceive('resetParameters')
            ->andReturn($client);

        $client->shouldReceive('setUri')->once()
            ->with('https://api.twitter.com/1.1/' . $path);

        if (!is_null($params)) {
            $setter = 'setParameter' . ucfirst(strtolower($method));
            $client->shouldReceive($setter)->once()->with($params);
        }

        $response = Mockery::mock('Zend\Http\Response');

        $response->shouldReceive('getBody')
            ->andReturn(isset($responseFile) ? file_get_contents(__DIR__ . '/../messages/' . $responseFile) : '');

        $client->shouldReceive('send')->once()->andReturn($response);

        return $client;
    }

    /**
     * @group mock
     */
    public function testSearch()
    {
        $twitter = new Twitter\Twitter;
        $twitter->setHttpClient($this->stubTwitter(
            'search/tweets.json', Http\Request::METHOD_GET, 'twitter_search.json'),
            array('q' => '#phpunit')
        );
        $response = $twitter->search->tweets('#phpunit');
        $this->assertInstanceOf('\ZendService\Twitter\Response',$response);
    }

    /**
     * @group apiCall
     */
    public function testSearchLive()
    {
        $twitter = new Twitter\Twitter(
            array(
            'access_token' => array(
                'token'  => TWITTER_ACCESS_TOKEN,
                'secret' => TWITTER_ACCESS_SECRET,
            ),
            'oauth_options' => array(
                'consumerKey' => TWITTER_CONSUMER_KEY,
                'consumerSecret' => TWITTER_CONSUMER_SECRET,
               ),
            'http_client_options' => array(
                'adapter' => 'Zend\Http\Client\Adapter\Curl',
                'curloptions' => array(
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                ),
            ),
            )
        );

        $response = $twitter->search->tweets('#phpunit');
        $this->assertInstanceOf('\ZendService\Twitter\Response',$response);
        $this->assertTrue($response->isSuccess());
    }
}
