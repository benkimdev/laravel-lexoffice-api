<?php

namespace Bendev\LexOffice\Exceptions;

use DateTime;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiException extends \Exception
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * ISO8601 representation of the moment this exception was thrown
     *
     * @var \DateTimeImmutable
     */
    protected $raisedAt;

    /**
     * @var array
     */
    protected $links = [];

    /**
     * @param string $message
     * @param int $code
     * @param string|null $field
     * @param RequestInterface|null $request
     * @param ResponseInterface|null $response
     * @param \Throwable|null $previous
     * @throws \Bendev\LexOffice\Api\Exceptions\ApiException
     */
    public function __construct(
        $message = "",
        $code = 0,
        $field = null,
        RequestInterface $request = null,
        ResponseInterface $response = null,
        $previous = null
    ) {
        $this->raisedAt = new \DateTimeImmutable();

        $formattedRaisedAt = $this->raisedAt->format(DateTime::ISO8601);
        $message = "[{$formattedRaisedAt}] " . $message;

        if (! empty($response)) {
            $this->response = $response;

            $object = static::parseResponseBody($this->response);

        }
        $this->request = $request;
        if ($request) {
            $requestBody = $request->getBody()->__toString();

            if ($requestBody) {
                $message .= ". Request body: {$requestBody}";
            }
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param \GuzzleHttp\Exception\GuzzleException $guzzleException
     * @param RequestInterface|null $request
     * @param \Throwable|null $previous
     * @return \Bendev\LexOffice\Api\Exceptions\ApiException
     * @throws \Bendev\LexOffice\Api\Exceptions\ApiException
     */
    public static function createFromGuzzleException(
        $guzzleException,
        $request = null,
        $previous = null
    ) {
        // Not all Guzzle Exceptions implement hasResponse() / getResponse()
        if (method_exists($guzzleException, 'hasResponse') && method_exists($guzzleException, 'getResponse')) {
            if ($guzzleException->hasResponse()) {
                return static::createFromResponse($guzzleException->getResponse(), $request, $previous);
            }
        }

        return new self($guzzleException->getMessage(), $guzzleException->getCode(), null, $request, null, $previous);
    }

    /**
     * @param ResponseInterface $response
     * @param RequestInterface $request
     * @param \Throwable|null $previous
     * @return Bendev\LexOffice\Exceptions\ApiException
     * @throws Bendev\LexOffice\Exceptions\ApiException
     */
    public static function createFromResponse(ResponseInterface $response, RequestInterface $request = null, $previous = null)
    {
        $object = static::parseResponseBody($response);

        $issueList = $object->IssueList[0];
        
        return new self(
            "Error executing API call - {$issueList->type} ({$issueList->i18nKey}: {$issueList->source})",
            $response->getStatusCode(),
            null,
            $request,
            $response,
            $previous
        );
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response !== null;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the ISO8601 representation of the moment this exception was thrown
     *
     * @return \DateTimeImmutable
     */
    public function getRaisedAt()
    {
        return $this->raisedAt;
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws Bendev\LexOffice\Exceptions\ApiException
     */
    protected static function parseResponseBody($response)
    {
        $body = (string) $response->getBody();

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new self("Unable to decode response: '{$body}'.");
        }

        return $object;
    }
}
