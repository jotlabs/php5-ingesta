<?php
namespace Ingesta\Clients;

interface XmlRpc
{
    public function callMethod($method, $params);
}
