<?php

namespace StackOverflow;

/**
 * Class Client
 * client for Stack Exchange API v2.0
 * @see https://api.stackexchange.com/docs
 * @package StackOverflow
 */
class Client
{
    /**
     * @var \CurlClient
     */
    private $curlClient;

    public function __construct(\CurlClient $curlClient)
    {
        $this->curlClient = $curlClient;
    }

    /**
     * @param $action
     * @param  array  $parameters
     * @return string
     */
    private function buildUrl($action, array $parameters)
    {
        $url = STACK_END_POINT_URL;
        $url .= '/' . STACK_API_VERSION;
        $url .= '/' . $action . '?';
        $url .= http_build_query($parameters);

        return $url;
    }

    public function search($term)
    {
        $url = $this->buildUrl('search',
            array('site' => 'stackoverflow',
                'order' => 'desc',
                'sort' => 'activity',
                'intitle' => $term,
                'filter' => 'default')
            );

        return $this->curlClient->sendRequest($url);
    }
}
