<?php
/**
 * GridyIDServiceApi
 * PHP version 7.4
 *
 * @category Class
 * @package  GridyAPI\Client
 * @author   
 * @link    
 */

/**
 * Gridy ID API
 *
 * Gridy ID is a Multi-Factor authentication (MFA) API service & Authenticator application for Android, IOS, Windows, MacOS, Linux & Web . 
 * 
 * Use Gridy to replace your existing username/password authentication or Integrate Gridy ID into your adaptive authentication workflow in 
 * minutes using our API service and clients
 * 
 
 */

namespace GridyAPI\Client\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use GridyAPI\Client\ApiException;
use GridyAPI\Client\Configuration;
use GridyAPI\Client\HeaderSelector;
use GridyAPI\Client\ObjectSerializer;

/**
 * GridyIDServiceApi Class Doc Comment
 *
 * @category Class
 * @package  GridyAPI\Client
 * @author   
 * @link     
 */
class GridyIDServiceApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /** @var string[] $contentTypes **/
    public const contentTypes = [
        'challenge' => [
            'application/json; charset=utf-8',
        ],
        'status' => [
            'application/json; charset=utf-8',
        ],
        'time' => [
            'application/json',
        ],
        'verify' => [
            'application/json; charset=utf-8',
        ],
    ];

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $hostIndex (Optional) host index to select the list of hosts if defined in the GridyAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: Configuration::getDefaultConfiguration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
        

    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index (required)
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation challenge
     *
     * Send or Cancel a Gridy ID MFA challenge request.
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID challenge request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['challenge'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse
     */
    public function challenge($api_request, string $contentType = self::contentTypes['challenge'][0])
    {
        list($response) = $this->challengeWithHttpInfo($api_request, $contentType);
        return $response;
    }

    /**
     * Operation challengeWithHttpInfo
     *
     * Send or Cancel a Gridy ID MFA challenge request.
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID challenge request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['challenge'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function challengeWithHttpInfo($api_request, string $contentType = self::contentTypes['challenge'][0])
    {
        $request = $this->challengeRequest($api_request, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 202:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\GridyAPI\Client\Model\ApiResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 202:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation challengeAsync
     *
     * Send or Cancel a Gridy ID MFA challenge request.
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID challenge request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['challenge'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function challengeAsync($api_request, string $contentType = self::contentTypes['challenge'][0])
    {
        return $this->challengeAsyncWithHttpInfo($api_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation challengeAsyncWithHttpInfo
     *
     * Send or Cancel a Gridy ID MFA challenge request.
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID challenge request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['challenge'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function challengeAsyncWithHttpInfo($api_request, string $contentType = self::contentTypes['challenge'][0])
    {
        $returnType = '\GridyAPI\Client\Model\ApiResponse';
        $request = $this->challengeRequest($api_request, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'challenge'
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID challenge request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['challenge'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function challengeRequest($api_request, string $contentType = self::contentTypes['challenge'][0])
    {

        // verify the required parameter 'api_request' is set
        if ($api_request === null || (is_array($api_request) && count($api_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $api_request when calling challenge'
            );
        }

        $resourcePath = '/v1/svc/challenge';
        $headerParams = [];
        $queryParams = [];
        $httpBody = '';

        $headers = $this->headerSelector->selectHeaders(
            ['application/json; charset=utf-8', ],
            $contentType,
            false
        );

        // for model (json/xml)
        if (isset($api_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($api_request));
            } else {
                $httpBody = $api_request;
            }
        } 
        
        /*
        
         $apirequest = new \GridyAPI\Client\Model\ApiRequest();
         $apirequest->setId("");
         $apirequest->setApiUser("");
         $apirequest->setUtcTime("");
         $apirequest->setType(\GridyAPI\Client\Model\ApiRequestType::CHALLENGE_NEW )
         $apirequest->setBody("");        
        */
       
        // this endpoint requires Hmac-Sha512 authentication        
        $apiUser = $this->config->getApiUser();
       
        $headers['x-gridy-apiuser'] = $apiUser;
        
        $utcTime = new \DateTime("now", new \DateTimeZone("UTC"));
        
        $headers['x-gridy-utctime'] = $utcTime-> format("Uv");      
        
        $headers['x-gridy-cnonce'] = vsprintf('%s%s-%s-%s-%s-%s%s%s',str_split(bin2hex(random_bytes(16)),4) );
        
        $signedHeadrs = sprintf( $this->config->getHmacSignedHeaders(), $headers['x-gridy-utctime'],$headers['x-gridy-cnonce'] );         
        
        $headers['Authorization'] = sprintf( $this->config->getHmacHttpAuthzHeader() , $this->config->getApiUser(), 
                    hash_hmac('sha512', $signedHeadrs, $this->config->getApiSecret(), false )  
                );   

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    
    
    
    
    /**
     * Operation status
     *
     * Check a Gridy ID MFA challenge status
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Status request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['status'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse
     */
    public function status($api_request, string $contentType = self::contentTypes['status'][0])
    {
        list($response) = $this->statusWithHttpInfo($api_request, $contentType);
        return $response;
    }

    /**
     * Operation statusWithHttpInfo
     *
     * Check a Gridy ID MFA challenge status
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Status request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['status'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function statusWithHttpInfo($api_request, string $contentType = self::contentTypes['status'][0])
    {
        $request = $this->statusRequest($api_request, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 204:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 404:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\GridyAPI\Client\Model\ApiResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 204:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation statusAsync
     *
     * Check a Gridy ID MFA challenge status
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Status request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['status'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function statusAsync($api_request, string $contentType = self::contentTypes['status'][0])
    {
        return $this->statusAsyncWithHttpInfo($api_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation statusAsyncWithHttpInfo
     *
     * Check a Gridy ID MFA challenge status
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Status request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['status'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function statusAsyncWithHttpInfo($api_request, string $contentType = self::contentTypes['status'][0])
    {
        $returnType = '\GridyAPI\Client\Model\ApiResponse';
        $request = $this->statusRequest($api_request, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'status'
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Status request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['status'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function statusRequest($api_request, string $contentType = self::contentTypes['status'][0])
    {

        // verify the required parameter 'api_request' is set
        if ($api_request === null || (is_array($api_request) && count($api_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $api_request when calling status'
            );
        }

        $resourcePath = '/v1/svc/status';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        $headers = $this->headerSelector->selectHeaders(
            ['application/json; charset=utf-8', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($api_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($api_request));
            } else {
                $httpBody = $api_request;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires Hmac authentication
        $apiUser = $this->config->getApiUser();
        $headers['x-gridy-apiuser'] = $apiUser;        
        
        $utcTime = new \DateTime("now", new \DateTimeZone( "UTC" ) );
        
        $headers['x-gridy-utctime'] = $utcTime-> format("Uv");
        
        $headers['x-gridy-cnonce'] = vsprintf('%s%s-%s-%s-%s-%s%s%s',str_split(bin2hex(random_bytes(16)),4) );
        
        $signedHeadrs = sprintf( $this->config->getHmacSignedHeaders(), $headers['x-gridy-utctime'],$headers['x-gridy-cnonce'] );         
        
        $headers['Authorization'] = sprintf( $this->config->getHmacHttpAuthzHeader(), $this->config->getApiUser(), 
                hash_hmac('sha512',  $signedHeadrs, $this->config->getApiSecret(), false )  );  

        
        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation time
     *
     * Get current UTC time
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['time'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse
     */
    public function time(string $contentType = self::contentTypes['time'][0])
    {
        list($response) = $this->timeWithHttpInfo($contentType);
        return $response;
    }

    /**
     * Operation timeWithHttpInfo
     *
     * Get current UTC time
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['time'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function timeWithHttpInfo(string $contentType = self::contentTypes['time'][0])
    {
        $request = $this->timeRequest($contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\GridyAPI\Client\Model\ApiResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation timeAsync
     *
     * Get current UTC time
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['time'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function timeAsync(string $contentType = self::contentTypes['time'][0])
    {
        return $this->timeAsyncWithHttpInfo($contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation timeAsyncWithHttpInfo
     *
     * Get current UTC time
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['time'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function timeAsyncWithHttpInfo(string $contentType = self::contentTypes['time'][0])
    {
        $returnType = '\GridyAPI\Client\Model\ApiResponse';
        $request = $this->timeRequest($contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'time'
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['time'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function timeRequest(string $contentType = self::contentTypes['time'][0])
    {


        $resourcePath = '/v1/svc/time';
        $headerParams = [];
        $queryParams = [];
        $formParams = [];              
        $httpBody = '';
     
        $headers = $this->headerSelector->selectHeaders(
            ['application/json; charset=utf-8', ],
            $contentType,
            false
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
         if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires API key authentication
         $apiUser = $this->config->getApiUser();
        
        $headers['x-gridy-apiuser'] = $apiUser;        
        
        $utcTime = new \DateTime("now", new \DateTimeZone( "UTC" ) );
        
        $headers['x-gridy-utctime'] = $utcTime-> format("Uv");   
        
        $headers['x-gridy-cnonce'] = vsprintf('%s%s-%s-%s-%s-%s%s%s',str_split(bin2hex(random_bytes(16)),4) );
        
        $signedHeadrs = sprintf( $this->config->getHmacSignedHeaders(), $headers['x-gridy-utctime'], headers['x-gridy-cnonce'] );         
             
        $headers['Authorization'] = sprintf( $this->config->getHmacHttpAuthzHeader(), $this->config->getApiUser(), 
                hash_hmac('sha512',$signedHeadrs, $this->config->getApiSecret(), false )  );  

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation verify
     *
     * Verify a Gridy ID authentication code
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse
     */
    public function verify($api_request, string $contentType = self::contentTypes['verify'][0])
    {
        list($response) = $this->verifyWithHttpInfo($api_request, $contentType);
        return $response;
    }

    /**
     * Operation verifyWithHttpInfo
     *
     * Verify a Gridy ID authentication code
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function verifyWithHttpInfo($api_request, string $contentType = self::contentTypes['verify'][0])
    {
        $request = $this->verifyRequest($api_request, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\GridyAPI\Client\Model\ApiResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation verifyAsync
     *
     * Verify a Gridy ID authentication code
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function verifyAsync($api_request, string $contentType = self::contentTypes['verify'][0])
    {
        return $this->verifyAsyncWithHttpInfo($api_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation verifyAsyncWithHttpInfo
     *
     * Verify a Gridy ID authentication code
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function verifyAsyncWithHttpInfo($api_request, string $contentType = self::contentTypes['verify'][0])
    {
        $returnType = '\GridyAPI\Client\Model\ApiResponse';
        $request = $this->verifyRequest($api_request, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'verify'
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function verifyRequest($api_request, string $contentType = self::contentTypes['verify'][0])
    {

        // verify the required parameter 'api_request' is set
        if ($api_request === null || (is_array($api_request) && count($api_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $api_request when calling verify'
            );
        }


        $resourcePath = '/v1/svc/verify';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        $headers = $this->headerSelector->selectHeaders(
            ['application/json; charset=utf-8', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($api_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($api_request));
            } else {
                $httpBody = $api_request;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires API key authentication
         $apiUser = $this->config->getApiUser();
        
         $headers['x-gridy-apiuser'] = $apiUser;        
        
         $utcTime = new \DateTime("now", new \DateTimeZone( "UTC" ) );
        
        $headers['x-gridy-utctime'] = $utcTime-> format("Uv");  
        
        $headers['x-gridy-cnonce'] = vsprintf('%s%s-%s-%s-%s-%s%s%s',str_split(bin2hex(random_bytes(16)),4) );
        
        $signedHeadrs = sprintf( $this->config->getHmacSignedHeaders(), $headers['x-gridy-utctime'],$headers['x-gridy-cnonce'] );         
        
        $headers['Authorization'] = sprintf( $this->config->getHmacHttpAuthzHeader(), $this->config->getApiUser(), 
                hash_hmac('sha512',  $signedHeadrs, $this->config->getApiSecret(), false )  );          
        
        
        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }
    
    
    
    
     /**
     * Operation blocked
     *
     * Check a User request against all defined IPv4 & User Blocked Rules
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse
     */
    public function blocked($api_request, string $contentType = self::contentTypes['blocked'][0])
    {
        list($response) = $this->blockedWithHttpInfo($api_request, $contentType);
        return $response;
    }

    /**
     * Operation blockedWithHttpInfo
     *
     * Check a User request against all defined IPv4 & User Blocked Rulese
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \GridyAPI\Client\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse|\GridyAPI\Client\Model\ApiResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function blockedWithHttpInfo($api_request, string $contentType = self::contentTypes['blocked'][0])
    {
        $request = $this->blockedRequest($api_request, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();


            switch($statusCode) {
                case 200:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    if ('\GridyAPI\Client\Model\ApiResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\GridyAPI\Client\Model\ApiResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\GridyAPI\Client\Model\ApiResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            $returnType = '\GridyAPI\Client\Model\ApiResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\GridyAPI\Client\Model\ApiResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation blockedAsync
     *
     * Check a User request against all defined IPv4 & User Blocked Rules
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function blockedAsync($api_request, string $contentType = self::contentTypes['blocked'][0])
    {
        return $this->blockedAsyncWithHttpInfo($api_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation blockedAsyncWithHttpInfo
     *
     * Check a User request against all defined IPv4 & User Blocked Rules
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Verify request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function blockedAsyncWithHttpInfo($api_request, string $contentType = self::contentTypes['blocked'][0])
    {
        $returnType = '\GridyAPI\Client\Model\ApiResponse';
        $request = $this->blockedRequest($api_request, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'blocked'
     *
     * @param  \GridyAPI\Client\Model\ApiRequest $api_request The JSON body of the request. Contains the Gridy ID Blocked request. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['verify'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function blockedRequest($api_request, string $contentType = self::contentTypes['blocked'][0])
    {

        // verify the required parameter 'api_request' is set
        if ($api_request === null || (is_array($api_request) && count($api_request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $api_request when calling verify'
            );
        }


        $resourcePath = '/v1/svc/blocked';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        $headers = $this->headerSelector->selectHeaders(
            ['application/json; charset=utf-8', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($api_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($api_request));
            } else {
                $httpBody = $api_request;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires API Hmac authentication
        $apiUser = $this->config->getApiUser();        
        $headers['x-gridy-apiuser'] = $apiUser;                
        $utcTime = new \DateTime("now", new \DateTimeZone( "UTC" ) );
        
        $headers['x-gridy-utctime'] = $utcTime-> format("Uv");  
        
        $headers['x-gridy-cnonce'] = vsprintf('%s%s-%s-%s-%s-%s%s%s',str_split(bin2hex(random_bytes(16)),4) );
        
        $signedHeadrs = sprintf( $this->config->getHmacSignedHeaders(), $headers['x-gridy-utctime'],$headers['x-gridy-cnonce'] );         
        
        $headers['Authorization'] = sprintf( $this->config->getHmacHttpAuthzHeader(), $this->config->getApiUser(), 
                hash_hmac('sha512',  $signedHeadrs, $this->config->getApiSecret(), false )  );          
        
        
        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }
    
    
  
    

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
