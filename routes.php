<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingsController@index');
$router->get('/listings/create', 'ListingsController@create');
$router->get('/listings/{id}', 'ListingsController@show');
$router->get('/listings/edit/{id}', 'ListingsController@edit');

$router->put('/listings/{id}', 'ListingsController@update');
$router->post('/listings', 'ListingsController@store');
$router->delete('/listings/{id}', 'ListingsController@destroy');
