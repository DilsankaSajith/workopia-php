<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingsController@index');
$router->get('/listings/create', 'ListingsController@create', ['auth']);
$router->get('/listings/{id}', 'ListingsController@show');
$router->get('/listings/edit/{id}', 'ListingsController@edit', ['auth']);

$router->put('/listings/{id}', 'ListingsController@update', ['auth']);
$router->post('/listings', 'ListingsController@store', ['auth']);
$router->delete('/listings/{id}', 'ListingsController@destroy', ['auth']);

$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);

$router->post('/auth/register', 'UserController@store', ['guest']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);
$router->post('/auth/login', 'UserController@authenticate', ['guest']);
