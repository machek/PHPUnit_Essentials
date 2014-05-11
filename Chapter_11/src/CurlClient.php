<?php

class CurlClient
{

    public function sendRequest($url)
    {
        $curl = curl_init($url);
        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");

        $response = curl_exec($curl);
        curl_close($curl);

        if (!$response || !$jsonResponse = json_decode($response)) {
            throw new \Exception('Invalid response');
        } else {
            return $jsonResponse;
        }
    }
}
