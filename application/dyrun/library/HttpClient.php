<?php

namespace app\dyrun\library;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * @property ResponseInterface $clientResponse
 * @property array $jsonRaw
 */
trait HttpClient
{

    /**
     * @var string
     */
    public $host = null;

    /**
     * @var string
     */
    public $method = 'POST';

    /**
     * @var string[]
     */
    public $jsonRaw = [];

    /**
     * @var Client
     */
    public $httpClient;

    /**
     * @var ResponseInterface
     */
    public $clientResponse;

    /**
     * @param string $host
     * @param int $timeout
     * @return void
     */
    public function setHttpClient(string $host, int $timeout = 10)
    {
        $this->httpClient = new Client([
            // Base URI is used with relative requests
            'base_uri' => $host,
            // You can set any number of default request options.
            'timeout' => $timeout,
        ]);
    }

    /**
     * @param string $uri
     * @return bool
     * @throws GuzzleException
     */
    public function requestClient(string $uri): bool
    {
        $this->clientResponse = $this->httpClient->request($this->method, $uri, [
            'json' => $this->jsonRaw['sign']
        ]);
        return true;
    }
}