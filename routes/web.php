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

    /* District Crud Operation*/
    $router->get('/district', 'LocDistrictController@index');
    $router->post('/district/add', 'LocDistrictController@store');
    $router->get('/district/show/{id}', 'LocDistrictController@show');
    $router->get('/district/edit/{id}', 'LocDistrictController@show');
    $router->get('/district/by-division/{division_id}', 'LocDistrictController@getDistrictByDivision');
    $router->put('/district/update/{id}', 'LocDistrictController@update');
    $router->delete('/district/delete/{id}', 'LocDistrictController@destroy');


    /* Upazila Crud Operation*/
    $router->get('/upazila', 'LocUpazilaController@index');
    $router->post('/upazila/add', 'LocUpazilaController@store');
    $router->get('/upazila/show/{id}', 'LocUpazilaController@show');
    $router->get('/upazila/edit/{id}', 'LocUpazilaController@show');
    $router->get('/upazila/by-district/{district_id}','LocUpazilaController@getUpazilaByDistrict');
    $router->put('/upazila/update/{id}', 'LocUpazilaController@update');
    $router->delete('/upazila/delete/{id}', 'LocUpazilaController@destroy');


});
