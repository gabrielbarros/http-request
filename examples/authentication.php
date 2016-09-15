<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$user = 'user0009';
$password = 'Q8174561F';

$http->setAuthentication($user, $password);

$http->get("https://httpbin.org/basic-auth/{$user}/{$password}");

header('Content-Type: text/plain');
echo $http->responseText;
