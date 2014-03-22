<?php
set_include_path(dirname(__FILE__) . '/../lib/' . PATH_SEPARATOR . get_include_path());

require 'Ingesta/Utils.php';
use Ingesta\Utils;

Utils::registerAutoloader();
