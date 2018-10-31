<?php
namespace HttpRequest;

class HttpRequest {

    public $charset = 'UTF-8';
    public $userAgent = 'curl';
    public $debug = false;
    public $followLocation = true;
    public $ignoreInvalidCert = false;
    public $connectTimeout = 30;
    public $timeout = 30;
    public $autoReferer = true;
    public $maxRedirs = 10;
    public $contentType;
    public $headersToObject = true;

    protected $url;
    protected $urlInfo;
    protected $query = [];
    protected $body;
    protected $upload = false;

    protected $cookies;
    protected $headers = [];
    protected $options = [];
    protected $username;
    protected $password;

    // Return variables
    public $error;
    public $errorMsg;
    public $responseText;
    public $responseHeaders;
    public $status;
    public $debugInfo;

    public function setQuery($query) {
        $this->query = $query;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function setCookies($cookie) {
        if (is_array($cookie)) {
            $this->cookies = http_build_query($cookie, '', '; ',
                PHP_QUERY_RFC3986);
        }

        else {
            $this->cookies = $cookie;
        }
    }

    public function setHeaders($headers) {
        foreach ($headers as $key => $value) {
            $this->headers[] = $key . ': ' . $value;
        }
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    public function setAuthentication($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function get($url) {
        return $this->request('GET', $url);
    }

    public function post($url) {
        return $this->request('POST', $url);
    }

    public function head($url) {
        return $this->request('HEAD', $url);
    }

    public function put($url) {
        return $this->request('PUT', $url);
    }

    public function delete($url) {
        return $this->request('DELETE', $url);
    }

    public function patch($url) {
        return $this->request('PATCH', $url);
    }

    public function request($method, $url) {

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid URL');
        }

        $this->url = $url;

        // Get URL information: host, path, scheme
        $this->urlInfo = parse_url($url);

        // cURL options
        $options = [];

        // HTTP method
        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
        }
        elseif ($method === 'HEAD') {
            $options[CURLOPT_NOBODY] = true;
        }
        elseif ($method !== 'GET') {
            $options[CURLOPT_CUSTOMREQUEST] = $method;
        }


        // Body message
        if (!is_null($this->body)) {

            // Form
            if (is_array($this->body)) {

                if ($this->upload) {
                    $options[CURLOPT_POSTFIELDS] = $this->body;
                }
                else {
                    $options[CURLOPT_POSTFIELDS] = http_build_query(
                        $this->body
                    );

                    $this->contentType = 'application/x-www-form-urlencoded;' .
                        ' charset=' . $this->charset;
                }
            }

            // JSON, XML, etc...
            else {
                $options[CURLOPT_POSTFIELDS] = $this->body;
            }

            if (isset($this->contentType)) {
                $this->setHeaders([
                    'Content-Type' => $this->contentType
                ]);
            }
        }

        $options[CURLOPT_URL] = $this->getFullUrl();
        $options[CURLOPT_HEADER] = true;
        $options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
        $options[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $options[CURLOPT_TIMEOUT] = $this->timeout;
        $options[CURLOPT_MAXREDIRS] = $this->maxRedirs;
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_ENCODING] = ''; // Accept-Encoding: "deflate, gzip"
        $options[CURLOPT_AUTOREFERER] = $this->autoReferer;
        $options[CURLOPT_FOLLOWLOCATION] = $this->followLocation;
        $options[CURLOPT_USERAGENT] = $this->userAgent;
        $options[CURLOPT_HTTPHEADER] = $this->headers;

        // Add request headers in debug mode
        if ($this->debug) {
            $options[CURLINFO_HEADER_OUT] = true;
        }

        // Set SSL certificate to securely access the page
        if (strtolower($this->urlInfo['scheme']) === 'https') {
            if ($this->ignoreInvalidCert) {
                $options[CURLOPT_SSL_VERIFYPEER] = false;
                $options[CURLOPT_SSL_VERIFYHOST] = 0;
            }
            else {
                $options[CURLOPT_SSL_VERIFYPEER] = true;
                $options[CURLOPT_SSL_VERIFYHOST] = 2;
                $options[CURLOPT_CAINFO] = __DIR__ . DIRECTORY_SEPARATOR .
                    'cacert.pem';
            }
        }

        // User and password to access the page
        if (isset($this->username, $this->password)) {
            $options[CURLOPT_USERPWD] = $this->username . ':' . $this->password;
        }

        // Set cookie
        if (isset($this->cookies)) {
            $options[CURLOPT_COOKIE] = $this->cookies;
        }

        // Custom cURL options
        foreach ($this->options as $key => $value) {
            $options[$key] = $value;
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $output = curl_exec($curl);
        $curlInfo = curl_getinfo($curl);

        // If an error has ocurred while requesting the URL...
        if (curl_errno($curl))  {
            $this->error = true;
            $this->errorMsg = curl_error($curl);
        }

        else {
            $this->error = false;

            if ($method === 'HEAD') {
                $this->responseText = $output;
                $responseHeaders = $output;
            }
            else {
                $headerSize = $curlInfo['header_size'];
                $this->responseText = substr($output, $headerSize);
                $responseHeaders = substr($output, 0, $headerSize);
            }

            if ($this->headersToObject) {
                $this->responseHeaders = $this->headersToObject(
                    $responseHeaders
                );
            }
            else {
                $this->responseHeaders = $responseHeaders;
            }

            $this->status = $curlInfo['http_code'];
        }

        if ($this->debug) {
            $requestHeader = isset($curlInfo['request_header']) ?
                $curlInfo['request_header'] : '';

            $requestBody = is_array($this->body) ?
                http_build_query($this->body) : $this->body;

            $request = $requestHeader . $requestBody;

            unset($curlInfo['request_header']);

            $this->debugInfo = array_merge($curlInfo, [
                'error_msg' => $this->errorMsg,
                'request' => $request,
                'response' => $output
            ]);
        }

        curl_close($curl);
    }

    private function getFullUrl() {
        $url = rtrim($this->url, '&?');

        if (is_string($this->query)) {
            if (strlen($this->query)) {
                $url .= '?' . $this->query;
            }
        }
        else if (is_array($this->query) && count($this->query)) {
            $buildQuery = http_build_query($this->query);

            if (isset($this->urlInfo['query'])) {
                $url .= '&' . $buildQuery;
            }
            else {
                $url .= '?' . $buildQuery;
            }
        }

        return $url;
    }

    private function headersToObject($headers) {

        // If method is HEAD and followLocation is true, the subsequent headers
        // will be combined, hence show only the last request
        $combinedHeaders = explode("\r\n\r\n", trim($headers));
        $combinedHeaders = end($combinedHeaders);

        $lines = explode("\r\n", $combinedHeaders);
        $objHeaders = new \StdClass();

        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);

            if (count($parts) > 1) {
                $key = strtr(strtolower($parts[0]), '-', '_');
                $value = trim($parts[1]);

                /*
                If header already exists, set it as an array, eg:
                    Cache-control: public
                    Cache-control: max-age=600
                Becomes:
                    cache_control = array(
                        [0] => 'public',
                        [1] => 'max-age=600'
                    )
                */
                if (isset($objHeaders->$key)) {
                    if (is_array($objHeaders->$key)) {
                        $objHeaders->$key[] = $value;
                    }
                    else {
                        $objHeaders->$key = [$objHeaders->$key, $value];
                    }
                }
                else {
                    $objHeaders->$key = $value;
                }
            }
        }

        return $objHeaders;
    }

    // Set some file to upload
    public function uploadFile($key, $path, $mimetype) {

        $filename = basename($path);
        $curlFile = new \CURLFile($path, $mimetype, $filename);

        $this->upload = true;
        $this->body[$key] = $curlFile;
    }
}
