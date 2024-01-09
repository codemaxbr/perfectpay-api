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
$router->post('/register', ['uses' => 'AuthController@register']);

$router->group(['middleware' => 'jwt.customer'], function() use ($router) {
    $router->post('/orders', ['uses' => 'OrderController@store']);
});


$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('/', ['uses' => 'ProductController@index']);
        $router->post('/', ['uses' => 'ProductController@store']);
        $router->put('/{id}', ['uses' => 'ProductController@update']);
        $router->delete('/{id}', ['uses' => 'ProductController@destroy']);
    });

    $router->group(['prefix' => 'customers'], function () use ($router) {
        $router->get('/', ['uses' => 'CustomerController@index']);
        $router->post('/', ['uses' => 'CustomerController@store']);
        $router->put('/{id}', ['uses' => 'CustomerController@update']);
        $router->delete('/{id}', ['uses' => 'CustomerController@destroy']);
    });

    $router->group(['prefix' => 'orders'], function () use ($router) {
        $router->get('/', ['uses' => 'OrderController@index']);
        $router->put('/{id}', ['uses' => 'OrderController@update']);
        $router->delete('/{id}', ['uses' => 'OrderController@destroy']);
    });
});
