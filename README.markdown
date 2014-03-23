Ingesta
=======

A service that ingests external data, processes it, and exports it.


Zend XMLRPC hacks
-----------------

To get the XMLRPC client working, after `composer install`, edit the following:

In `vendor/zendframework/zend-xmlrpc/Zend/XmlRpc/Response.php` line 157, change `XmlSecurity` to `\ZendXml\Security`.

In `vendor/zendframework/zend-xmlrpc/Zend/XmlRpc/Fault.php` line 184, change `XmlSecurity` to `\ZendXml\Security`.
