<?php

use Zend\XmlRpc\Server;
use Ingesta\Servers\XmlRpc\WeblogUpdates;

Flight::route('GET /ping/', function () {
    echo "XML-RPC Blogping server.";
});


Flight::route('POST /ping/', function () {
    $server   = new  Zend\XmlRpc\Server();

    $server->setClass(new WeblogUpdates(), 'weblogUpdates');

    $response = $server->handle();
    echo $response;
});
