<?php

class Transaction
{
    private $logger;
    private $client;
    private $data;
    private $response;

    public function __construct(ILogger $logger, HttpClient $client, array $data)
    {
        $this->logger = $logger;
        $this->client = $client;
        $this->data = $data;
    }

    public function prepareXMLRequest()
    {
        if(!isset($this->data['userId']))
        {
            throw new InvalidArgumentException('Missing userId');
        }

        if(!isset($this->data['items']) || !is_array($this->data['items']))
        {
            throw new InvalidArgumentException('Missing items');
        }

        $requestXML = new SimpleXMLElement("<request></request>");
        $requestXML->addAttribute('userId', $this->data['userId']);
        $itemsXML = $requestXML->addChild('items');

        foreach ($this->data['items'] as $item)
        {
            $itemXML = $itemsXML->addChild('item');
            $itemXML->addAttribute('id', $item['id']);
            $itemXML->addAttribute('quantity', $item['quantity']);
        }

        return $requestXML->asXML();
    }

    public function sendRequest()
    {
        $xmlRequest = $this->prepareXMLRequest();
        $this->client->setRequest($xmlRequest);
        $this->logger->log($xmlRequest, ILogger::PRIORITY_INFO);
        $this->response = $this->client->send();
        return $this->response;
    }

    public function wasSent()
    {
        return !empty($this->response);
    }
}