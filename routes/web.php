<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group(['prefix'=>'api/v1'], function() use($router){
    $router->get('/division', 'LocDivisionController@index');
    $router->post('/division', 'LocDivisionController@store');
    $router->get('/division/{id}', 'LocDivisionController@show');
    $router->put('/division/{id}', 'LocDivisionController@update');
    $router->delete('/division/{id}', 'LocDivisionController@destroy');
});
