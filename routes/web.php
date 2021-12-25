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
    return phpinfo();
});

$router->group(['prefix' => 'project', 'middleware' => 'auth'], function () use ($router) {
    $router->post('create', 'ProjectController@create');
    $router->post('copy', 'ProjectController@copy');
    $router->post('update', 'ProjectController@update');
    $router->post('rename/{id}', 'ProjectController@rename');
    $router->delete('delete/{id}', 'ProjectController@delete');
    $router->get('{id}', 'ProjectController@get');
});

$router->get('projects', 'ProjectController@projects');

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('register', 'UserController@register');
    $router->post('login', 'UserController@login');
    $router->delete('delete', [
        'middleware' => 'auth',
        'uses' => 'UserController@delete'
    ]);
});
