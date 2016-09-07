<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$http->setOptions(array(
    CURLOPT_FAILONERROR => true,
    CURLOPT_FORBID_REUSE => true
));

$http->get('https://www.google.com/404-NOT-FOUND');

header('content-type: text/plain');

if ($http->error) {
    echo $http->errorMsg;
}
