<?php

Flight::route('/', function () {
    echo "<h1>Ingesta</h1>";
});

include 'routes.php';

Flight::start();
