<?php
include '../base-constants.php';
require AUTOLOADER;

Flight::route('/', function () {
    echo "<h1>Ingesta</h1>";
});

Flight::start();
