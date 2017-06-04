<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->followLocation = false;
$http->get('https://httpbin.org/redirect-to?url=https%3A%2F%2Fwww.google.com%2Fhumans.txt');

header('Content-Type: text/plain');

$headers = $http->responseHeaders;
echo $headers->location;

