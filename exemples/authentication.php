<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$user = 'user0009';
$password = 'Q8174561F';

$http->setAuthentication($user, $password);

$http->get("https://httpbin.org/basic-auth/{$user}/{$password}");

header('content-type: text/plain');
echo $http->responseText;
