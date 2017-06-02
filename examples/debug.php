<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();
$http->debug = true;

$http->userAgent = 'Hello world';

$http->setCookies(array(
    'cookie_test' => 'The quick brown fox jumps over the lazy dog'
));

$http->setHeaders(array(
    'X-Some-Header' => '123456'
));

$http->get('https://www.google.com/humans.txt');

header('Content-Type: text/plain');
print_r($http->debugInfo);
