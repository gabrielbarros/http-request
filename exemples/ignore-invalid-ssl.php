<?php
include '../HttpRequest.class.php';

$http = new HttpRequest();

$http->setOptions(array(
    CURLOPT_SSL_VERIFYPEER => false
));

$http->get('https://expired.badssl.com');

header('content-type: text/plain');

if ($http->error) {
    echo $http->errorMsg;
}

else {
    echo $http->responseText;
}
