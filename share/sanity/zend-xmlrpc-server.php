<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Zend\XmlRpc\Server;

$server = new  Zend\XmlRpc\Server();
$response = $server->handle();
echo $response;
