<?php

namespace app\common\HttpClient;

use GuzzleHttp\Client;

/**
 * Class HttpClient
 * @package app\common\HttpClient
 */
class HttpClient
{
    /**
     * @param string $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(string $url): string
    {
        $client = new Client(['base_uri' => 'http://www.world-art.ru/']);
        $response = $client->request('GET', $url, [
            'headers' => [
                'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36'
            ]]);

        return $response->getBody()->getContents();
    }
}