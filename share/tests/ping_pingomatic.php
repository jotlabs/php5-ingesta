<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Zend\XmlRpc\Client;

$endpoint = 'http://rpc.pingomatic.com/';
$client   = new Client($endpoint);

$params   = array(
    'Shenzhen Geek Trails',
    'http://shenzhen.geektrails.com/'
);
$result   = $client->call('weblogUpdates.ping', $params);

echo "XmlRpc response: ";
print_r($result);
echo "\n";
