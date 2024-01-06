<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', ['uses' => 'AuthController@login']);

$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('/', ['uses' => 'ProductController@index']);
        $router->post('/', ['uses' => 'ProductController@store']);
        $router->put('/{id}', ['uses' => 'ProductController@update']);
        $router->delete('/{id}', ['uses' => 'ProductController@destroy']);
    });
});
