<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

$router->get('people', function () {
    return response()->json([
        'data' => [
            0 => [
                'firstName' => 'Jacek',
                'lastName' => 'Dus'
            ],
            1 => [
                'firstName' => 'Karolina',
                'lastName' => 'Pacek'
            ],
        ]
    ]);
});

$router->get('foo', function () {
    return 'bar';
});

$router->get('test', function () {
    return app('db')->select('SELECT * FROM people');
});
