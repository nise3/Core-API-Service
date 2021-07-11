<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router) {
    /* Authentication related routes */
    $router->post('auth/login', 'Auth\AuthController@login');
    $router->post('auth/register', 'Auth\AuthController@register');

    /* division Crud Operation */
    $router->get('divisions', ['as' => 'divisions.get-list', 'uses' => 'LocDivisionController@getList']);
    $router->post('divisions', ['as' => 'divisions.store', 'uses' => 'LocDivisionController@store']);
    $router->get('divisions/{id}', ['as' => 'divisions.read', 'uses' => 'LocDivisionController@read']);
    $router->put('divisions/{id}', ['as' => 'divisions.update', 'uses' => 'LocDivisionController@update']);
    $router->delete('divisions/{id}', ['as' => 'divisions.destroy', 'uses' => 'LocDivisionController@destroy']);

    /* districts Crud Operation*/
    $router->get('districts', ['as' => 'districts.get-list', 'uses' => 'LocDistrictController@getList']);
    $router->post('districts', ['as' => 'districts.store', 'uses' => 'LocDistrictController@store']);
    $router->get('districts/{id}', ['as' => 'districts.read', 'uses' => 'LocDistrictController@read']);
    $router->put('districts/{id}', ['as' => 'districts.update', 'uses' => 'LocDistrictController@update']);
    $router->delete('districts/{id}', ['as' => 'districts.destroy', 'uses' => 'LocDistrictController@destroy']);

    /* Upazila Crud Operation*/
    $router->get('upazilas', ['as' => 'upazilas.get-list', 'uses' => 'LocUpazilaController@getList']);
    $router->post('upazilas', ['as' => 'upazilas.store', 'uses' => 'LocUpazilaController@store']);
    $router->get('upazilas/{id}', ['as' => 'upazilas.read', 'uses' => 'LocUpazilaController@read']);
    $router->put('upazilas/{id}', ['as' => 'upazilas.update', 'uses' => 'LocUpazilaController@update']);
    $router->delete('upazilas/{id}', ['as' => 'upazilas.destroy', 'uses' => 'LocUpazilaController@destroy']);

    // private route with auth token
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('auth/profile', 'Auth\AuthController@profile');
        $router->post('auth/logout', 'Auth\AuthController@logout');
    });
});
