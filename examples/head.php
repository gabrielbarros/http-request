<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setQuery(array(
    'number' => '12345'
));

$http->head('https://httpbin.org/get');

header('Content-Type: text/plain');
echo $http->responseText;
