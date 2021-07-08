<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group( ['prefix'=>'api/v1' ,'as'=>'api.v1'], function() use($router){

    /* Authentication related routes */
    $router->post('/auth/login', 'Auth\AuthController@login');
    $router->post('/auth/register', 'Auth\AuthController@register');

    // private route with auth token
    $router->group( ['middleware'=> 'auth'], function() use($router){
        $router->post('/auth/profile', 'Auth\AuthController@profile');
        $router->post('/auth/logout', 'Auth\AuthController@logout');

        /* division Crud Operation */
        $router->get('/divisions', ['as'=>'divisions.view-all','uses'=>'LocDivisionController@viewAll']);
        $router->post('/divisions', ['as'=>'divisions.store','uses'=>'LocDivisionController@store']);
        $router->get('/divisions/{id}', ['as'=>'divisions.view','uses'=>'LocDivisionController@view']);
        $router->put('/divisions/{id}', ['as'=>'divisions.update','uses'=>'LocDivisionController@update']);
        $router->delete('/divisions/{id}', ['as'=>'divisions.destroy','uses'=>'LocDivisionController@destroy']);

        /* districts Crud Operation*/
        $router->get('/districts', ['as'=>'districts.view-all','uses'=>'LocDistrictController@viewAll']);
        $router->post('/districts', ['as'=>'districts.store','uses'=>'LocDistrictController@store']);
        $router->get('/districts/{id}', ['as'=>'districts.view','uses'=>'LocDistrictController@view']);
        $router->put('/districts/{id}', ['as'=>'districts.update','uses'=>'LocDistrictController@update']);
        $router->delete('/districts/{id}', ['as'=>'districts.destroy','uses'=>'LocDistrictController@destroy']);
        $router->get('/districts/by-division/{division_id}', ['as'=>'districts.by_division','uses'=>'LocDistrictController@getDistrictByDivision']);

        /* Upazila Crud Operation*/
        $router->get('/upazilas', ['as'=>'upazilas.view-all','uses'=>'LocUpazilaController@viewAll']);
        $router->post('/upazilas', ['as'=>'upazilas.store','uses'=>'LocUpazilaController@store']);
        $router->get('/upazilas/{id}', ['as'=>'upazilas.view','uses'=>'LocUpazilaController@view']);
        $router->put('/upazilas/{id}', ['as'=>'upazilas.update','uses'=>'LocUpazilaController@update']);
        $router->delete('/upazilas/{id}', ['as'=>'upazilas.destroy','uses'=>'LocUpazilaController@destroy']);
        $router->get('/upazilas/by-district/{district_id}', ['as'=>'upazilas.by_district','uses'=>'LocUpazilaController@getUpazilaByDistrict']);

    });

});
