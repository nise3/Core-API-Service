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

    /* districts Crud Operation*/
    $router->get('/districts', ['as'=>'districts.viewAll','uses'=>'LocDistrictController@viewAll']);
    $router->post('/districts', ['as'=>'districts.store','uses'=>'LocDistrictController@store']);
    $router->get('/districts/{id}', ['as'=>'districts.view','uses'=>'LocDistrictController@view']);
    $router->put('/districts/{id}', ['as'=>'districts.update','uses'=>'LocDistrictController@update']);
    $router->delete('/districts/{id}', ['as'=>'districts.destroy','uses'=>'LocDistrictController@destroy']);
    $router->get('/districts/by-division/{division_id}', ['as'=>'districts.by_division','uses'=>'LocDistrictController@getDistrictByDivision']);

    /* Upazila Crud Operation*/
    $router->get('/upazilas', ['as'=>'upazilas.viewAll','uses'=>'LocUpazilaController@viewAll']);
    $router->post('/upazilas', ['as'=>'upazilas.store','uses'=>'LocUpazilaController@store']);
    $router->get('/upazilas/{id}', ['as'=>'upazilas.view','uses'=>'LocUpazilaController@view']);
    $router->put('/upazilas/{id}', ['as'=>'upazilas.update','uses'=>'LocUpazilaController@update']);
    $router->delete('/upazilas/{id}', ['as'=>'upazilas.destroy','uses'=>'LocUpazilaController@destroy']);
    $router->get('/upazilas/by-district/{district_id}', ['as'=>'upazilas.by_district','uses'=>'LocUpazilaController@getUpazilaByDistrict']);
});
