<?php

/** @var $router \Illuminate\Routing\Router */

$router->group(['prefix' => '/protected'], function ($router) {
    /** @var $router \Illuminate\Routing\Router */
    $router->get('/secret', function () {
        return response()->json(['secret hallo from deveo']);
    });

    $router->post('/secret', function () {
        return response()->json('secret hallo from deveo');
    });
});
