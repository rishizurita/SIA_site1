<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//unsecure routes
//$router->group(['prefix' =>'api'], function () use ($router) {
    //$router->get('/users', ['uses'=> 'UserController@getUsers']);


// Unsecure routes with correct prefix
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'UserController@getUsers');
    $router->post('/users', 'UserController@add');
    $router->get('/users/{id}', 'UserController@show');
    $router->put('/users/{id}', 'UserController@update');
    $router->patch('/users/{id}', 'UserController@update');
    $router->delete('/users/{id}', 'UserController@delete');
    
    $router->get('/usersjob', 'UserJobController@index');
    $router->get('/userjob/{id}', 'UserJobController@show'); 
});