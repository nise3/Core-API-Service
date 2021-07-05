<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group( ['prefix'=>'api/v1'], function() use($router){
    /* division Crud Operation*/
    $router->get('/division', 'LocDivisionController@index');
    $router->post('/division/add', 'LocDivisionController@store');
    $router->get('/division/show/{id}', 'LocDivisionController@show');
    $router->get('/division/edit/{id}', 'LocDivisionController@show');
    $router->put('/division/update/{id}', 'LocDivisionController@update');
    $router->delete('/division/delete/{id}', 'LocDivisionController@destroy');


});
