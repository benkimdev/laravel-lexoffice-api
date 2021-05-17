<?php 

namespace Bendev\LexOffice;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Bendev\LexOffice\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Bendev\LexOffice\Endpoints\InvoiceEndpoint;
use Bendev\LexOffice\Endpoints\ContactEndpoint;

class LexOfficeClient
{

    /**
     * Version of our client.
     */
    const CLIENT_VERSION = "0.0.1";

    /**
     * Endpoint of the remote API.
     */
    const API_ENDPOINT = "https://api.lexoffice.io";

    /**
     * Version of the remote API.
     */
    const API_VERSION = "v1";

    /**
     * HTTP Methods
     */
    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_DELETE = "DELETE";
    const HTTP_PATCH = "PATCH";

    /**
     * HTTP status codes
     */
    const HTTP_NO_CONTENT = 204;

    /**
     * Default response timeout (in seconds).
     */
    const TIMEOUT = 10;

    /**
     * Default connect timeout (in seconds).
     */
    const CONNECT_TIMEOUT = 2;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * RESTful Customers resource.
     *
     * @var ContactEndpoint
     */
    public $contacts;

    /**
     * RESTful Invoice resource.
     *
     * @var InvoiceEndpoint
     */
    public $invoices;


    /**
     * @param ClientInterface $httpClient
     *
     * @throws IncompatiblePlatform
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;

        if (! $this->httpClient) {
            $handlerStack = HandlerStack::create();

            $this->httpClient = new Client([
                GuzzleRequestOptions::TIMEOUT => self::TIMEOUT,
                GuzzleRequestOptions::CONNECT_TIMEOUT => self::CONNECT_TIMEOUT,
                'handler' => $handlerStack,
            ]);
        }

        $this->initializeEndpoints();
    }

    public function initializeEndpoints()
    {
        $this->contacts = new ContactEndpoint($this);
        $this->invoices = new InvoiceEndpoint($this);
    }

    /**
     * @param string $url
     *
     * @return LexOfficeClient
     */
    public function setApiEndpoint($url)
    {
        $this->apiEndpoint = rtrim(trim($url), '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @param string $apiKey
     *
     * @return LexOfficeApiClient
     * @throws ApiException
     */
    public function setApiKey($apiKey)
    {
        $apiKey = trim($apiKey);

        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Perform an http call. This method is used by the resource specific classes. Please use the $payments property to
     * perform operations on payments.
     *
     * @param string $httpMethod
     * @param string $apiMethod
     * @param string|null|resource|StreamInterface $httpBody
     *
     * @return \stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $url = $this->apiEndpoint . "/" . self::API_VERSION . "/" . $apiMethod;

        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * Perform an http call to a full url. This method is used by the resource specific classes.
     *
     * @see $payments
     * @see $isuers
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null|resource|StreamInterface $httpBody
     *
     * @return \stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null)
    {
        if (empty($this->apiKey)) {
            throw new ApiException("You have not set an API key or OAuth access token. Please use setApiKey() to set the API key.");
        }

        $headers = [
            'Accept' => "application/json",
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => "application/json",
        ];

        $request = new Request($httpMethod, $url, $headers, $httpBody);

        try {
            $response = $this->httpClient->send($request, ['http_errors' => false]);
        } catch (GuzzleException $e) {
            throw ApiException::createFromGuzzleException($e, $request);
        }

        if (! $response) {
            throw new ApiException("Did not receive API response.", 0, null, $request);
        }

        return $this->parseResponseBody($response);
    }


    /**
     * Parse the PSR-7 Response body
     *
     * @param ResponseInterface $response
     * @return \stdClass|null
     * @throws ApiException
     */
    private function parseResponseBody(ResponseInterface $response)
    {
        $body = (string) $response->getBody();
        if (empty($body)) {
            if ($response->getStatusCode() === self::HTTP_NO_CONTENT) {
                return null;
            }

            throw new ApiException("No response body found.");
        }

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode response: '{$body}'.");
        }

        if ($response->getStatusCode() >= 400) {
            throw ApiException::createFromResponse($response, null);
        }

        return $object;
    }

}