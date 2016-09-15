<?php
require 'autoload.php';

use HttpRequest\HttpRequest;

$http = new HttpRequest();

$http->setOptions(array(
    CURLOPT_SSL_VERIFYPEER => false
));

$http->get('https://expired.badssl.com');

header('Content-Type: text/plain');

if ($http->error) {
    echo $http->errorMsg;
}

else {
    echo $http->responseText;
}
