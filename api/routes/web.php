<?php

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->post('/login', 'AuthController@login');
        $router->post('/logout', 'AuthController@logout');
        $router->get('/pass', 'PassController@index');
        $router->post('/pass', 'PassController@store');
        $router->get('/addresses', 'AddressController@index');

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('/users/me', 'AuthController@me');
            $router->put('/pass/{id}', 'PassController@update');
            $router->delete('/pass/{id}', 'PassController@destroy');


        });
    });

    $router->get('/', function () {
        return response()->json(['messasge'=>'asf']);
    });
});
