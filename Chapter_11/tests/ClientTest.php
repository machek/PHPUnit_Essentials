<?php

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function testRunkitSearch()
    {
        runkit_function_redefine('curl_exec', '$curl', 'return file_get_contents(dirname(__FILE__) . "/messages/search.json");');

        $curlClient = new CurlClient();
        $client = new \StackOverFlow\Client($curlClient);
        $response = $client->search('phpunit');
        $this->assertNotNull($response);
        $this->assertFalse(isset($response->error_id));
    }

} 