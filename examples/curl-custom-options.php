<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setOptions(array(
    CURLOPT_FAILONERROR => true,
    CURLOPT_FORBID_REUSE => true
));

$http->get('https://www.google.com/404-NOT-FOUND');

header('Content-Type: text/plain');

if ($http->error) {
    echo $http->errorMsg;
}
