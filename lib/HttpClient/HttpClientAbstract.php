<?php


namespace Epigeon\HttpClient;

/**
 * Class HttpClient
 * @package Epigeon\HttpClient
 *
 * Client used to make HTTP requests.
 */
abstract class HttpClientAbstract
{
    /**
     * @var EnvironmentInterface
     */
    public EnvironmentInterface $environment;

    /**
     * @var array
     */
    public array $injectors = [];

    /**
     * @var Encoder
     */
    public Encoder $encoder;

    /**
     * HttpClient constructor. Pass the environment you wish to make calls to.
     *
     * @param EnvironmentInterface $environment
     *
     * @see EnvironmentInterface
     */
    function __construct( EnvironmentInterface $environment)
    {
        $this->environment = $environment;
        $this->encoder = new Encoder();
    }

    /**
     * Injectors are blocks that can be used for executing arbitrary pre-flight logic, such as modifying a request or logging data.
     * Executed in first-in first-out order.
     *
     * @param HeaderInjectorInterface $inj
     */
    public function addInjector(HeaderInjectorInterface $inj): void
    {
        $this->injectors[] = $inj;
    }

    /**
     * function execute
     *
     * @param HttpRequest $httpRequest
     *
     * @return HttpResponse
     * @throws HttpException
     * @throws \Exception
     */
    public function execute(HttpRequest $httpRequest): HttpResponse {
        $requestCpy = clone $httpRequest;
        $curl = new Curl();

        foreach ($this->injectors as $inj) {
            $inj->inject($requestCpy);
        }

        $formattedHeaders = $this->prepareHeaders($requestCpy->headers);
        if (array_key_exists("authorization", $formattedHeaders) && preg_match('/Basic (.+)/', $formattedHeaders['authorization'], $match)) {
            $curl->setOpt(CURLOPT_USERPWD, base64_decode($match[1]));
        }

        $curl->setOpt(CURLOPT_URL, $this->environment->baseUrl() . $requestCpy->path);
        $curl->setOpt(CURLOPT_CUSTOMREQUEST, $requestCpy->verb);
        $curl->setOpt(CURLOPT_HTTPHEADER, $this->serializeHeaders($requestCpy->headers));
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_HEADER, 0);
        if (!is_null($requestCpy->body)) {
            $rawHeaders = $requestCpy->headers;
            $requestCpy->headers = $formattedHeaders;
            $requestCpy->headers = $this->mapHeaders($rawHeaders,$requestCpy->headers);
            $body = $this->encoder->serializeRequest($requestCpy);
            $curl->setOpt(CURLOPT_POSTFIELDS, $body);
        }

        if (str_starts_with($this->environment->baseUrl(), "https://")) {
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, 2);
        }

        if (null !== $this->getCACertFilePath()) {
            $curl->setOpt(CURLOPT_CAINFO, $this->getCACertFilePath());
        }

        $response = $this->parseResponse($curl);
        $curl->close();

        return $response;
    }

    /**
     * Returns an array representing headers with their keys
     * to be lower case
     * @param $headers
     * @return array
     */
    public function prepareHeaders($headers): array
    {
        $preparedHeaders = array_change_key_case($headers);
        if (array_key_exists("content-type", $preparedHeaders)) {
            $preparedHeaders["content-type"] = strtolower($preparedHeaders["content-type"]);
        }
        return $preparedHeaders;
    }

    /**
     * Returns an array representing headers with their key in
     * original cases and updated values
     * @param $rawHeaders
     * @param $formattedHeaders
     * @return array
     */
    public function mapHeaders($rawHeaders, $formattedHeaders): array
    {
        $rawHeadersKey = array_keys($rawHeaders);
        foreach ($rawHeadersKey as $array_key) {
            if(array_key_exists(strtolower($array_key), $formattedHeaders)){
                $rawHeaders[$array_key] = $formattedHeaders[strtolower($array_key)];
            }
        }
        return $rawHeaders;
    }

    /**
     * Return the filepath to your custom CA Cert if needed.
     * @return string|null
     */
    protected function getCACertFilePath(): ?string
    {
        return null;
    }

    /**
     * function serializeHeaders
     *
     * @param $headers
     *
     * @return array
     */
    private function serializeHeaders($headers): array
    {
        $headerArray = [];
        if ($headers) {
            foreach ($headers as $key => $val) {
                $headerArray[] = $key . ": " . $val;
            }
        }

        return $headerArray;
    }

    /**
     * function parseResponse
     *
     * @param $curl
     *
     * @return HttpResponse
     * @throws HttpException
     */
    private function parseResponse($curl): HttpResponse
    {
        $headers = [];
        $curl->setOpt(CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);

                $k = "";
                $v = "";

                $this->deserializeHeader($header, $k, $v);
                $headers[$k] = $v;

                return $len;
            });

        $responseData = $curl->exec();
        $statusCode = $curl->getInfo(CURLINFO_HTTP_CODE);
        $errorCode = $curl->errNo();
        $error = $curl->error();

        if ($errorCode > 0) {
            throw new HttpException($error, $errorCode, $headers);
        }

        $body = $responseData;

        if ($statusCode >= 200 && $statusCode < 300) {
            $responseBody = NULL;

            if (!empty($body)) {
                if(!array_key_exists('content-type', $headers) || $headers['content-type'] !== 'application/epub+zip'){
                    $responseBody = $this->encoder->deserializeResponse($body, $this->prepareHeaders($headers));
                } else {
                    $responseBody = $body;
                }
            }

            return new HttpResponse(
                $errorCode === 0 ? $statusCode : $errorCode,
                $responseBody,
                $headers
            );
        } else {
            throw new HttpException($body, $statusCode, $headers);
        }
    }

    /**
     * function deserializeHeader
     *
     * @param $header
     * @param $key
     * @param $value
     *
     * @return void
     */
    private function deserializeHeader($header, &$key, &$value): void
    {
        if (strlen($header) > 0) {
            if (empty($header) || !str_contains($header, ':')) {
                return;
            }

            [$k, $v] = explode(":", $header);
            $key = trim($k);
            $value = trim($v);
        }
    }
}
