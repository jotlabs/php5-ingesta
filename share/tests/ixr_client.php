<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use \IXR_Client;

$endpoint = 'http://lotsofyoga.com/mind-body-spirit/xmlrpc.php';

$client = new IXR_Client($endpoint);
$client->query('demo.sayHello');
$response = $client->getResponse();

echo "XMLRPC Response: ";
print_r($response);
echo "\n";
