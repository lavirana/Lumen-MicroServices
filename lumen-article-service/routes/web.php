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


$router->get('/articles', 'ArticleController@index');
$router->post('/articles', 'ArticleController@store');
$router->get('/articles/{id}', 'ArticleController@show');
$router->put('/articles/{id}', 'ArticleController@update');
$router->delete('/articles/{id}', 'ArticleController@destroy');
