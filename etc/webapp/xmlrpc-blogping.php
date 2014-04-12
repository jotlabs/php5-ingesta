<?php

Flight::route('GET /ping/', function () {
    echo "XML-RPC Blogping server.";
});

Flight::route('POST /ping/', function () {

});
