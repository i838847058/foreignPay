<?php

namespace app\dyrun\library;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * @property ResponseInterface $clientResponse
 * @property array $jsonRaw
 * @property string $host
 * @property string $method
 * @property Client $httpClient
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
     * @param string $paramType
     * @return bool
     * @throws GuzzleException
     */
    public function requestClient(string $uri, string $paramType = 'json'): bool
    {
        switch ($paramType) {
            case 'json':
                $option['json'] = $this->jsonRaw;
                break;
            default:
                $option = [];
                break;
        }
        $this->clientResponse = $this->httpClient->request($this->method, $uri, $option);
        return true;
    }
}