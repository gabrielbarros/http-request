<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$cookies = [
    'name' => 'John Smith',
    'age' => '30',
    'role' => 'manager'
];

$http->setCookies($cookies);
$http->get('https://httpbin.org/get');

header('Content-Type: text/plain');
echo $http->responseText;
