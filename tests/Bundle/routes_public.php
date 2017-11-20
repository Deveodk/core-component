<?php

/** @var $router \Illuminate\Routing\Router */

$router->get('/', function () {
    return response()->json(['hallo from deveo']);
});

$router->post('/', function () {
    return response()->json('hallo from deveo');
});
