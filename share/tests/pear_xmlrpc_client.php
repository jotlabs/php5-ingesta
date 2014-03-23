<?php
//require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'XML/RPC2/Client.php';

$endpoint = 'http://lotsofyoga.com/mind-body-spirit/xmlrpc.php';

$options = array(
    'prefix' => 'demo.'
);

$client = XML_RPC2_Client::create($endpoint, $options);
$result = $client->sayHello('test');

echo "XMLRPC response: ";
print_r($result);
echo "\n";
