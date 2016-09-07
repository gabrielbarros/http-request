<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();
$http->userAgent = HttpRequest::UA_GOOGLEBOT;

$headers = array(
    'X-Authentication' => '698dc19d489c4e4db73e28a713eab07b',
    'X-Anything' => 'some header you want to send'
);

$http->setHeaders($headers);
$http->get('https://httpbin.org/get');

header('content-type: text/plain');
echo $http->responseText;
