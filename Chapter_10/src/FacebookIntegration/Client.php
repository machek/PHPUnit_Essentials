<?php
namespace FacebookIntegration;

use Facebook;

class Client
{
    const TYPE_POST = 'post';
    const TYPE_PAGE = 'page';

    /**
     * @var \Facebook
     */
    private $facebook;

    public function __construct(\Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->facebook->getAccessToken();
    }

    /**
     * @param string $term
     * @param string $type
     * @return mixed
     */
    public function search($term, $type, $limit = 10)
    {
        $params = array('q'=> $term, 'type'=>$type, 'limit'=>$limit);
        return $this->facebook->api('/search?'.http_build_query($params));
    }
}
