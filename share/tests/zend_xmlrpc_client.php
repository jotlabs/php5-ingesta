<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Zend\XmlRpc\Client;

##$endpoint = 'http://lotsofyoga.com/mind-body-spirit/xmlrpc.php';
$endpoint = 'http://cms.hostlite.co.uk/xmlrpc.php';
$client   = new Client($endpoint);

$result   = $client->call('demo.sayHello');

echo "XmlRpc response: ";
print_r($result);
echo "\n";
echo "----\n";

//$client = new Client('http://cms.hostlite.co.uk/xmlrpc.php');
$params = array(
    1,
    'ingesta',
    'f0cba5b3d83a995e4b2a37f65561c249'
);


$result = $client->call('wp.getPosts', $params);
echo "XmlRpc response: ";
print_r($result);
echo "\n";
