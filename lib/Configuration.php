<?php
/**
 * Configuration
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
 * Gridy ID is a Multi-Factor authentication (MFA) API service & Authenticator application for Android, IOS, Windows, MacOS, Linux & Web.
 * 
 * Use Gridy to replace your existing username/password authentication or integrate Gridy ID into your adaptive authentication workflow in minutes 
 * using our API service and clients.
 *
 */

namespace GridyAPI\Client;

/**
 * Configuration Class Doc Comment
 * PHP version 7.4
 *
 * @category Class
 * @package  GridyAPI\Client
 * @author   
 * @link     
 */
class Configuration
{
    public const BOOLEAN_FORMAT_INT = 'int';
    public const BOOLEAN_FORMAT_STRING = 'string';

    /**
     * @var Configuration
     */
    private static $defaultConfiguration;

  

    /**
     * Boolean format for query string
     *
     * @var string
     */
    protected $booleanFormatForQueryString = self::BOOLEAN_FORMAT_INT;

    /**
     * Gridy ID API User
     *
     * @var string
     */
    protected $apiUser = '';

    /**
     * Gridy ID API User Secret Key
     *
     * @var string
     */
    protected $apiSecret = '';

    /**
     * Gridy HMAC-SHA512 HTTP Authorization Header
     *
     * @var string
     */
    protected $hmacAuthHdrFormat = "gridy-hmac: apiuser=%s,signedheaders=x-gridy-utctime;x-gridy-cnonce,algorithm=gridy-hmac512,signature=%s";
   
    
    /**
     * Gridy HMAC-SHA512 HTTP Authorization Signed Headers
     *
     * @var string
     */
    protected $hmacSignedHdrs = "x-gridy-utctime: %s\nx-gridy-cnonce: %s";
   
    
    
    
    /**
     * The host
     *
     * @var string
     */
    protected $host = 'https://api.gridy.io/prod';

    /**
     * User agent of the HTTP request
     *
     * @var string
     */
    protected $userAgent = 'gridy-php-client-v0.5.0';

    /**
     * Debug switch (default set to false)
     *
     * @var bool
     */
    protected $debug = true;

    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $debugFile = 'php://output';

    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $tempFolderPath;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tempFolderPath = sys_get_temp_dir();
    }
    
    
     /**
     * Gets the apiUser for HTTP GRIDY-HMAC-SHA512 authentication
     *
     * @return string apiUser for HTTP GRIDY-HMAC-SHA512 authentication
     */
    public function getApiUser()
    {
        return $this->apiUser;
    }

    /**
     * Sets the Gridy ID Api User
     *
     * @param string $apiuser for HTTP GRIDY-HMAC-SHA512 authentication
     *
     * @return $this
     */
    public function setApiUser( $apiuser )
    {
        $this->apiUser = $apiuser;
        return $this;
    }

    /**
     * Gets the secret key used for HTTP GRIDY-HMAC-SHA512 authentication
     *
     * @return string ApiSecret for HTTP GRIDY-HMAC-SHA512 authentication
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }
    
   
     /**
     * Sets the secret key used for HTTP GRIDY-HMAC-SHA512 authentication
     *
     * @param string $secret for HTTP GRIDY-HMAC-SHA512 authentication
     *
     * @return $this
     */
    public function setApiSecret( $secret )
    {
        $this->apiSecret = $secret;
        return $this;
    }
    
    
    
    
     /**
     * Gets the  HTTP GRIDY-HMAC-SHA512 Authorization Header
     *
     * @return string Authorization for GRIDY-HTTP HMAC-SHA512 authentication
     */
    public function getHmacHttpAuthzHeader()
    {
        return $this->hmacAuthHdrFormat;
    }

   
     /**
     * Gets the  HTTP GRIDY-HMAC-SHA512 Authorization Signed Headers
     *
     * @return string Authorization for HTTP GRIDY-HMAC-SHA512 authentication
     */
    public function getHmacSignedHeaders()
    {
        return $this->hmacSignedHdrs;
    }
    
    
    

    /**
     * Sets boolean format for query string.
     *
     * @param string $booleanFormat Boolean format for query string
     *
     * @return $this
     */
    public function setBooleanFormatForQueryString(string $booleanFormat)
    {
        $this->booleanFormatForQueryString = $booleanFormat;

        return $this;
    }

    /**
     * Gets boolean format for query string.
     *
     * @return string Boolean format for query string
     */
    public function getBooleanFormatForQueryString(): string
    {
        return $this->booleanFormatForQueryString;
    }

    /**
     * Sets the host
     *
     * @param string $host Host
     *
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Gets the host
     *
     * @return string Host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Sets the user agent of the api client
     *
     * @param string $userAgent the user agent of the api client
     *
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setUserAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            throw new \InvalidArgumentException('User-agent must be a string.');
        }

        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * Gets the user agent of the api client
     *
     * @return string user agent
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Sets debug flag
     *
     * @param bool $debug Debug flag
     *
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Gets the debug flag
     *
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Sets the debug file
     *
     * @param string $debugFile Debug file
     *
     * @return $this
     */
    public function setDebugFile($debugFile)
    {
        $this->debugFile = $debugFile;
        return $this;
    }

    /**
     * Gets the debug file
     *
     * @return string
     */
    public function getDebugFile()
    {
        return $this->debugFile;
    }

    /**
     * Sets the temp folder path
     *
     * @param string $tempFolderPath Temp folder path
     *
     * @return $this
     */
    public function setTempFolderPath($tempFolderPath)
    {
        $this->tempFolderPath = $tempFolderPath;
        return $this;
    }

    /**
     * Gets the temp folder path
     *
     * @return string Temp folder path
     */
    public function getTempFolderPath()
    {
        return $this->tempFolderPath;
    }

    /**
     * Gets the default configuration instance
     *
     * @return Configuration
     */
    public static function getDefaultConfiguration()
    {
        if (self::$defaultConfiguration === null) {
            self::$defaultConfiguration = new Configuration();
        }

        return self::$defaultConfiguration;
    }

    /**
     * Sets the default configuration instance
     *
     * @param Configuration $config An instance of the Configuration Object
     *
     * @return void
     */
    public static function setDefaultConfiguration(Configuration $config)
    {
        self::$defaultConfiguration = $config;
    }

    /**
     * Gets the essential information for debugging
     *
     * @return string The report for debugging
     */
    public static function toDebugReport()
    {
        $report  = 'PHP SDK (GridyAPI\Client) Debug Report:' . PHP_EOL;
        $report .= '    OS: ' . php_uname() . PHP_EOL;
        $report .= '    PHP Version: ' . PHP_VERSION . PHP_EOL;
        $report .= '    The version of the Gridy API document: 1.0.0' . PHP_EOL;
        $report .= '    Temp Folder Path: ' . self::getDefaultConfiguration()->getTempFolderPath() . PHP_EOL;

        return $report;
    }

    /**
     * Get API key (with prefix if set)
     *
     * @param  string $apiKeyIdentifier name of apikey
     *
     * @return null|string API key with the prefix
     */
    public function getApiKeyWithPrefix($apiKeyIdentifier)
    {
        $prefix = $this->getApiKeyPrefix($apiKeyIdentifier);
        $apiKey = $this->getApiKey($apiKeyIdentifier);

        if ($apiKey === null) {
            return null;
        }

        if ($prefix === null) {
            $keyWithPrefix = $apiKey;
        } else {
            $keyWithPrefix = $prefix . ' ' . $apiKey;
        }

        return $keyWithPrefix;
    }

    /**
     * Returns an array of host settings
     *
     * @return array an array of host settings
     */
    public function getHostSettings()
    {
        return [
            [
                "url" => "https://api.gridy.io/prod",
                "description" => "",
            ],
            [
                "url" => "https://uat.gridy.io/uat",
                "description" => "",
            ]
        ];
    }

    /**
    * Returns URL based on host settings, index and variables
    *
    * @param array      $hostSettings array of host settings, generated from getHostSettings() or equivalent from the API clients
    * @param int        $hostIndex    index of the host settings
    * @param array|null $variables    hash of variable and the corresponding value (optional)
    * @return string URL based on host settings
    */
    public static function getHostString(array $hostSettings, $hostIndex, array $variables = null)
    {
        if (null === $variables) {
            $variables = [];
        }

        // check array index out of bound
        if ($hostIndex < 0 || $hostIndex >= count($hostSettings)) {
            throw new \InvalidArgumentException("Invalid index $hostIndex when selecting the host. Must be less than ".count($hostSettings));
        }

        $host = $hostSettings[$hostIndex];
        $url = $host["url"];

        // go through variable and assign a value
        foreach ($host["variables"] ?? [] as $name => $variable) {
            if (array_key_exists($name, $variables)) { // check to see if it's in the variables provided by the user
                if (!isset($variable['enum_values']) || in_array($variables[$name], $variable["enum_values"], true)) { // check to see if the value is in the enum
                    $url = str_replace("{".$name."}", $variables[$name], $url);
                } else {
                    throw new \InvalidArgumentException("The variable `$name` in the host URL has invalid value ".$variables[$name].". Must be ".join(',', $variable["enum_values"]).".");
                }
            } else {
                // use default value
                $url = str_replace("{".$name."}", $variable["default_value"], $url);
            }
        }

        return $url;
    }

    /**
     * Returns URL based on the index and variables
     *
     * @param int        $index     index of the host settings
     * @param array|null $variables hash of variable and the corresponding value (optional)
     * @return string URL based on host settings
     */
    public function getHostFromSettings($index, $variables = null)
    {
        return self::getHostString($this->getHostSettings(), $index, $variables);
    }
}
