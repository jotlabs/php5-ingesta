<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Zend\XmlRpc\Client;

$endpoint = 'http://lotsofyoga.com/mind-body-spirit/xmlrpc.php';
$client   = new Client($endpoint);

$result   = $client->call('demo.sayHello', 'schadenfreude');

echo "XmlRpc response: ";
print_r($result);
echo "\n";
