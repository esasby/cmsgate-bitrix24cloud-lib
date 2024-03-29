<?php


namespace esas\cmsgate\protocol;

use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\Logger;;

class Bitrix24RestClient
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * access token
     * @var string
     */
    protected $accessToken = null;

    /**
     * refresh token
     * @var string
     */
    protected $refreshToken = null;

    /**
     * domain
     * @var string
     */
    protected $domain = null;

    /**
     * scope
     * @var array
     */
    protected $applicationScope = array();

    /**
     * application id
     * @var string
     */
    protected $applicationId = null;

    /**
     * application secret
     * @var string
     */
    protected $applicationSecret = null;

    /**
     * application code
     * @var string
     */
    protected $applicationCode = null;

    /**
     * raw request, contain all cURL options array and API query
     * @var array
     */
    protected $rawRequest = null;

    /**
     * @var array, contain all api-method parameters, vill be available after call method
     */
    protected $methodParameters = null;

    /**
     * request info data structure from curl_getinfo function
     * @var array
     */
    protected $requestInfo = null;

    /**
     * @var bool if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
     */
    protected $isSaveRawResponse = false;

    /**
     * @var array raw response from bitrix24
     */
    protected $rawResponse = null;

    /**
     * @var string redirect URI from application settings
     */
    protected $redirectUri = null;

    /**
     * @var string portal GUID
     */
    protected $memberId = null;

    protected $debugMode = false;

    /**
     * Create a object to work with Bitrix24 REST API service
     * @param bool $isSaveRawResponse - if true raw response from bitrix24 will be available from method getRawResponse, this is debug mode
     * @throws CmsgateException
     */
    public function __construct($isSaveRawResponse = false)
    {
        if (!extension_loaded('curl')) {
            throw new CmsgateException('cURL extension must be installed to use this library');
        }
        if (!is_bool($isSaveRawResponse)) {
            throw new CmsgateException('isSaveRawResponse flag must be boolean');
        }
        $this->logger = Logger::getLogger(get_class($this));
        $this->isSaveRawResponse = $isSaveRawResponse;
    }


    /**
     * Set member ID — portal GUID
     * @param string $memberId
     * @return true;
     * @throws CmsgateException
     */
    public function setMemberId($memberId)
    {
        if (!empty($memberId)) {
            $this->memberId = $memberId;
            return true;
        } else {
            throw new CmsgateException('memberId is empty');
        }
    }

    /**
     * Get memeber ID
     * @return string | null
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set redirect URI
     * @param string $redirectUri
     * @return true;
     * @throws CmsgateException
     */
    public function setRedirectUri($redirectUri)
    {
        if (!empty($redirectUri)) {
            $this->redirectUri = $redirectUri;
            return true;
        } else {
            throw new CmsgateException('redirect URI not set');
        }
    }

    /**
     * Get redirect URI
     * @return string | null
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set access token
     * @param string $accessToken
     * @return true;
     * @throws CmsgateException
     */
    public function setAccessToken($accessToken)
    {
        if (!empty($accessToken)) {
            $this->accessToken = $accessToken;
            return true;
        } else {
            throw new CmsgateException('access token not set');
        }
    }

    /**
     * Get access token
     * @return string | null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set refresh token
     * @param $refreshToken
     * @return true;
     * @throws CmsgateException
     */
    public function setRefreshToken($refreshToken)
    {
        if (!empty($refreshToken)) {
            $this->refreshToken = $refreshToken;
            return true;
        } else {
            throw new CmsgateException('refresh token not set');
        }
    }

    /**
     * Get refresh token
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Set domain
     * @param $domain
     * @return true;
     * @throws CmsgateException
     */
    public function setDomain($domain)
    {
        if (!empty($domain)) {
            $this->domain = $domain;
            return true;
        } else {
            throw new CmsgateException('domain not set');
        }
    }

    /**
     * Get domain
     * @return string | null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set application scope
     * @param array $applicationScope
     * @return boolean
     * @throws CmsgateException
     */
    public function setApplicationScope(array $applicationScope)
    {
        if (is_array($applicationScope) && count($applicationScope) > 0) {
            $this->applicationScope = $applicationScope;
            return true;
        } else {
            throw new CmsgateException('application scope not set');
        }
    }


    /**
     * Get application scope
     */
    public function getApplicationScope()
    {
        return $this->applicationScope;
    }

    /**
     * Set application id
     * @param string $applicationId
     * @return true;
     * @throws CmsgateException
     */
    public function setApplicationId($applicationId)
    {
        if (!empty($applicationId)) {
            $this->applicationId = $applicationId;
            return true;
        } else {
            throw new CmsgateException('application id not set');
        }
    }// end of SetApplicationId

    /**
     * Get application id
     * @return string
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Set application secret
     * @param string $applicationSecret
     * @return true;
     * @throws CmsgateException
     */
    public function setApplicationSecret($applicationSecret)
    {
        if (!empty($applicationSecret)) {
            $this->applicationSecret = $applicationSecret;
            return true;
        } else {
            throw new CmsgateException('application secret not set');
        }
    }

    /**
     * Get application secret
     * @return string
     */
    public function getApplicationSecret()
    {
        return $this->applicationSecret;
    }


    public function getApplicationCode()
    {
        return $this->applicationCode;
    }


    public function setApplicationCode($code)
    {
        $this->applicationCode = $code;
    }

    /**
     * @param bool $debugMode
     */
    public function setDebugMode($debugMode) {
        $this->debugMode = $debugMode;
    }

    public function requestAccessToken()
    {
        $applicationid = $this->getApplicationId();
        $applicationSecret = $this->getApplicationSecret();
        $code = $this->getApplicationCode();

        $url = 'https://oauth.bitrix.info/oauth/token/?grant_type=authorization_code&' .
            'client_id=' . urlencode($applicationid) .
            '&client_secret=' . $applicationSecret .
            '&code=' . $code;

        $requestResult = $this->executeRequest($url);

        if (isset($requestResult['error'])) return false;
        else return $requestResult;
    }


    public function requestCode()
    {
        $domain = $this->getDomain();
        $applicationid = $this->getApplicationId();
        $redirectUri = $this->getRedirectUri();

        $url = 'https://' . $domain . '/oauth/authorize/?client_id=' .
            urlencode($applicationid) . '&response_type=code' .
            '&redirect_url=' . urlencode($redirectUri);

        redirect($url);
    }

    /**
     * Return raw request, contain all cURL options array and API query. Data available after you try to call method call
     * numbers of array keys is const of cURL module. Example: CURLOPT_RETURNTRANSFER = 19913
     * @return array | null
     */
    public function getRawRequest()
    {
        return $this->rawRequest;
    }

    /**
     * Return result from function curl_getinfo. Data available after you try to call method call
     * @return array | null
     */
    public function getRequestInfo()
    {
        return $this->requestInfo;
    }

    /**
     * Return additional parameters of last api-call. Data available after you try to call method call
     * @return array | null
     */
    public function getMethodParameters()
    {
        return $this->methodParameters;
    }

    /**
     * Execute a request API to Bitrix24 using cURL
     * @param string $url
     * @param array $additionalParameters
     * @return array
     * @throws CmsgateException
     */
    protected function executeRequest($url, array $additionalParameters = array())
    {

        //\cnLog::Add(" ==== ".$url);
        //\cnLog::Add(" ==== ".http_build_query($additionalParameters));

        /**
         * @todo add method to set custom cURL options
         */
        $curlOptions = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
//            CURLOPT_USERAGENT => strtolower(__CLASS__ . '-PHP-SDK/v' . self::VERSION),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($additionalParameters),
            CURLOPT_URL => $url
        );

        // if (strpos($url, 'lead') !== false)	{
        // print_r($curlOptions); die;
        // }
        $this->rawRequest = $curlOptions;
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        $curlResult = curl_exec($curl);
        $this->requestInfo = curl_getinfo($curl);
        $curlErrorNumber = curl_errno($curl);

        if ($this->debugMode) {
            $this->logger->info('REQUEST url: ' . $url . "\n\n"
                . 'REQUEST params: ' . print_r($additionalParameters, true) . "\n\n"
                . 'REQUEST curl raw result: ' . print_r($curlResult, true) . "\n\n"
                . 'REQUEST curl info: ' . print_r($this->requestInfo, true));
        }

        // handling network I/O errors
        if ($curlErrorNumber > 0) {
            $errorMsg = curl_error($curl) . PHP_EOL . 'cURL error code: ' . $curlErrorNumber . PHP_EOL;
            if ($this->debugMode)
                $this->logger->info('REQUEST curl error: ' . '[' . $curlErrorNumber . '] ' . $errorMsg);


            curl_close($curl);
            throw new Bitrix24IoException($errorMsg);
        } else {
            curl_close($curl);
        }
        if (true === $this->isSaveRawResponse) {
            $this->rawResponse = $curlResult;
        }
        // handling json_decode errors
        $jsonResult = json_decode($curlResult, true);
        $jsonErrorCode = json_last_error();
        if (!is_null($jsonResult) && (JSON_ERROR_NONE == $jsonErrorCode)) unset($curlResult);

        if ($this->debugMode)
            $this->logger->info('REQUEST curl decoded JSON result: ' . print_r($jsonResult, true));

        if (is_null($jsonResult) && (JSON_ERROR_NONE != $jsonErrorCode)) {
            /**
             * @todo add function json_last_error_msg()
             */
            switch ($jsonErrorCode) {
                case JSON_ERROR_NONE:
                    $jsonErrorMessage = 'No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    $jsonErrorMessage = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $jsonErrorMessage = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $jsonErrorMessage = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $jsonErrorMessage = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $jsonErrorMessage = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $jsonErrorMessage = 'Unknown error';
                    break;
            }
            $errorMsg = 'URL: ' . $url . PHP_EOL . ' Fatal error in function json_decode.' . PHP_EOL . 'Error code: ' . $jsonErrorCode . ' (' . $jsonErrorMessage . ') ' . PHP_EOL . $curlResult . PHP_EOL;//." on data ".$curlResult.PHP_EOL;
            throw new CmsgateException($errorMsg);
        }
        return $jsonResult;
    }

    /**
     * Execute Bitrix24 REST API method
     * @param string $methodName
     * @param array $additionalParameters
     * @return array
     * @throws CmsgateException
     */
    public function call($methodName, array $additionalParameters = array())
    {
        if (is_null($this->getDomain())) {
            throw new CmsgateException('domain not found, you must call setDomain method before');
        }
        if (is_null($this->getAccessToken())) {
            throw new CmsgateException('access token not found, you must call setAccessToken method before');
        }
        if (0 == strlen($methodName)) {
            throw new CmsgateException('method name not found, you must set method name');
        }
        $url = 'https://' . $this->domain . '/rest/' . $methodName;
        $additionalParameters['auth'] = $this->accessToken;
        // save method parameters for debug
        $this->methodParameters = $additionalParameters;
        // is secure api-call?
        $isSecureCall = false;
        if (array_key_exists('state', $additionalParameters)) {
            $isSecureCall = true;
        }

        $requestResult = $this->executeRequest($url, $additionalParameters);

        // handling bitrix24 api-level errors
        if (array_key_exists('error', $requestResult)) {
            $errName = $requestResult['error'];
            $errDescription = '';
            if (isset($requestResult['error_description'])) {
                $errDescription = $requestResult['error_description'];
            }
            $errorMsg = $errName . $errDescription . 'in call: [ ' . $methodName . ' ]';
            throw new CmsgateException($errorMsg);
        }

        // handling security sign for secure api-call
        if ($isSecureCall) {
            if (array_key_exists('signature', $requestResult)) {
                // check signature structure
                if (strpos($requestResult['signature'], '.') === false) {
                    throw new CmsgateException('security signature is corrupted');
                }
                if (is_null($this->getMemberId())) {
                    throw new CmsgateException('member-id not found, you must call setMemberId method before');
                }
                if (is_null($this->getApplicationSecret())) {
                    throw new CmsgateException('application secret not found, you must call setApplicationSecret method before');
                }
                // prepare
                $key = md5($this->getMemberId() . $this->getApplicationSecret());
                $delimiterPosition = strrpos($requestResult['signature'], '.');
                $dataToDecode = substr($requestResult['signature'], 0, $delimiterPosition);
                $signature = base64_decode(substr($requestResult['signature'], $delimiterPosition + 1));
                // compare signatures
                $hash = hash_hmac('sha256', $dataToDecode, $key, true);
                if ($hash !== $signature) {
                    throw new CmsgateException('security signatures not same, bad request');
                }
                // decode
                $arClearData = json_decode(base64_decode($dataToDecode), true);
                // handling json_decode errors
                $jsonErrorCode = json_last_error();
                if (is_null($arClearData) && (JSON_ERROR_NONE != $jsonErrorCode)) {
                    /**
                     * @todo add function json_last_error_msg()
                     */
                    $errorMsg = 'fatal error in function json_decode.' . PHP_EOL . 'Error code: ' . $jsonErrorCode . PHP_EOL;
                    throw new CmsgateException($errorMsg);
                }
                // merge dirty and clear data
                unset($arClearData['state']);
                $requestResult ["result"] = array_merge($requestResult ["result"], $arClearData);
            } else {
                throw new CmsgateException('security signature in api-response not found');
            }
        }
        return $requestResult;
    }

    /**
     * Get raw response from Bitrix24 before json_decode call, method available only in debug mode.
     * To activate debug mode you must before set to true flag isSaveRawResponse in class construct
     * @return string
     * @throws CmsgateException
     */
    public function getRawResponse()
    {
        if (false === $this->isSaveRawResponse) {
            throw new CmsgateException('you must before set to true flag isSaveRawResponse in class construct');
        }
        return $this->rawResponse;
    }

    /**
     * Get new access token
     * @return array
     * @throws CmsgateException
     */
    public function getNewAccessToken()
    {
        $domain = $this->getDomain();
        $applicationId = $this->getApplicationId();
        $applicationSecret = $this->getApplicationSecret();
        $refreshToken = $this->getRefreshToken();

        if (is_null($domain)) {
            throw new CmsgateException('domain not found, you must call setDomain method before');
        } elseif (is_null($applicationId)) {
            throw new CmsgateException('application id not found, you must call setApplicationId method before');
        } elseif (is_null($applicationSecret)) {
            throw new CmsgateException('application id not found, you must call setApplicationSecret method before');
        } elseif (is_null($refreshToken)) {
            throw new CmsgateException('application id not found, you must call setRefreshToken method before');
        }
        $url = "https://oauth.bitrix.info/oauth/token/" .
            "?client_id=" . urlencode($applicationId) .
            "&grant_type=refresh_token" .
            "&client_secret=" . $applicationSecret .
            "&refresh_token=" . $refreshToken;
        $requestResult = $this->executeRequest($url);
        if (isset($requestResult['error'])) return false;
        else return $requestResult;
    }

    /**
     * Сheck is access token expire, сall list of all available api-methods from B24 portal with current access token
     * if we have an error code expired_token then return true else return false
     * @return boolean
     * @throws CmsgateException
     */
    public function isAccessTokenExpire()
    {
        $isTokenExpire = false;
        $accessToken = $this->getAccessToken();
        $domain = $this->getDomain();

        if (is_null($domain)) {
            throw new CmsgateException('domain not found, you must call setDomain method before');
        } elseif (is_null($accessToken)) {
            throw new CmsgateException('application id not found, you must call setAccessToken method before');
        }
        $url = 'https://' . $domain . "/rest/methods.json?auth=" . $accessToken . '&full=true';
        $requestResult = $this->executeRequest($url);
        if (
            (isset($requestResult['error'])) &&
            (('expired_token' == $requestResult['error']) || ('invalid_token' == $requestResult['error']))) {
            $isTokenExpire = true;
        }
        return $isTokenExpire;
    }

    /**
     * Get list of all methods available for current application
     * @param array | null $applicationScope
     * @param bool $isFull
     * @return array
     * @throws CmsgateException
     */
    public function getAvailableMethods($applicationScope = array(), $isFull = false)
    {
        $accessToken = $this->getAccessToken();
        $domain = $this->getDomain();

        if (is_null($domain)) {
            throw new CmsgateException('domain not found, you must call setDomain method before');
        } elseif (is_null($accessToken)) {
            throw new CmsgateException('application id not found, you must call setAccessToken method before');
        }

        $showAll = '';
        if (TRUE === $isFull) {
            $showAll = '&full=true';
        }
        $scope = '';
        if (is_null($applicationScope)) {
            $scope = '&scope';
        } elseif (count(array_unique($applicationScope)) > 0) {
            $scope = '&scope=' . implode(',', array_map('urlencode', array_unique($applicationScope)));
        }
        $url = 'https://' . $domain . "/rest/methods.json?auth=" . $accessToken . $showAll . $scope;
        $requestResult = $this->executeRequest($url);
        return $requestResult;
    }

    /**
     * get list of scope for current application from bitrix24 api
     * @param bool $isFull
     * @return array
     * @throws CmsgateException
     */
    public function getScope($isFull = false)
    {
        $accessToken = $this->getAccessToken();
        $domain = $this->getDomain();

        if (is_null($domain)) {
            throw new CmsgateException('domain not found, you must call setDomain method before');
        } elseif (is_null($accessToken)) {
            throw new CmsgateException('application id not found, you must call setAccessToken method before');
        }
        $showAll = '';
        if (TRUE === $isFull) {
            $showAll = '&full=true';
        }
        $url = 'https://' . $domain . "/rest/scope.json?auth=" . $accessToken . $showAll;
        $requestResult = $this->executeRequest($url);
        return $requestResult;
    }
}