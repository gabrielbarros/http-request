<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$http->get('https://httpbin.org/get');

header('content-type: text/plain');
print_r($http->responseHeaders);
