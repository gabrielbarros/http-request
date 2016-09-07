<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$cookies = array(
    'name' => 'John Smith',
    'age' => '30',
    'role' => 'manager'
);

$http->setCookies($cookies);
$http->get('https://httpbin.org/get');

header('content-type: text/plain');
echo $http->responseText;
