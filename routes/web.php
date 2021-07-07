<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group( ['prefix'=>'api/v1' ,'as'=>'api.v1'], function() use($router){

    /* division Crud Operation */
    $router->get('/divisions', ['as'=>'divisions.viewAll','uses'=>'LocDivisionController@viewAll']);
    $router->post('/divisions', ['as'=>'divisions.store','uses'=>'LocDivisionController@store']);
    $router->get('/divisions/{id}', ['as'=>'divisions.view','uses'=>'LocDivisionController@view']);
    $router->put('/divisions/{id}', ['as'=>'divisions.update','uses'=>'LocDivisionController@update']);
    $router->delete('/divisions/{id}', ['as'=>'divisions.destroy','uses'=>'LocDivisionController@destroy']);


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
