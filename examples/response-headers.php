<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

// $http->headersToObject = false;

$http->get('https://httpbin.org/get');

header('Content-Type: text/plain');
print_r($http->responseHeaders);
