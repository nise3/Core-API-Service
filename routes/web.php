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

    /* Permission Crud Operation*/
    $router->get('permissions', ['as' => 'permissions.get-list', 'uses' => 'PermissionController@getList']);
    $router->post('permissions', ['as' => 'permissions.store', 'uses' => 'PermissionController@store']);
    $router->get('permissions/{id}', ['as' => 'permissions.read', 'uses' => 'PermissionController@read']);
    $router->put('permissions/{id}', ['as' => 'permissions.update', 'uses' => 'PermissionController@update']);
    $router->delete('permissions/{id}', ['as' => 'permissions.destroy', 'uses' => 'PermissionController@destroy']);

    /* Permission Group Crud Operation*/
    $router->get('permission-groups', ['as' => 'permission-groups.get-list', 'uses' => 'PermissionGroupController@getList']);
    $router->post('permission-groups', ['as' => 'permission-groups.store', 'uses' => 'PermissionGroupController@store']);
    $router->get('permission-groups/{id}', ['as' => 'permission-groups.read', 'uses' => 'PermissionGroupController@read']);
    $router->put('permission-groups/{id}', ['as' => 'permission-groups.update', 'uses' => 'PermissionGroupController@update']);
    $router->delete('permission-groups/{id}', ['as' => 'permission-groups.destroy', 'uses' => 'PermissionGroupController@destroy']);

    /* assign permission to permission group*/
    $router->post('permission-groups/assign-permissions/{id}', ['as' => 'permission-groups.assign-permissions', 'uses' => 'PermissionGroupController@assignPermissionToPermissionGroup']);


    /* Permission Group Crud Operation*/
    $router->get('permission-sub-groups', ['as' => 'permission-sub-groups.get-list', 'uses' => 'PermissionSubGroupController@getList']);
    $router->post('permission-sub-groups', ['as' => 'permission-sub-groups.store', 'uses' => 'PermissionSubGroupController@store']);
    $router->get('permission-sub-groups/{id}', ['as' => 'permission-sub-groups.read', 'uses' => 'PermissionSubGroupController@read']);
    $router->put('permission-sub-groups/{id}', ['as' => 'permission-sub-groups.update', 'uses' => 'PermissionSubGroupController@update']);
    $router->delete('permission-sub-groups/{id}', ['as' => 'permission-sub-groups.destroy', 'uses' => 'PermissionSubGroupController@destroy']);

    /* assign permission to permission group*/
    $router->post('permission-sub-groups/assign-permissions/{id}', ['as' => 'permission-sub-groups.assign-permissions', 'uses' => 'PermissionSubGroupController@assignPermissionToPermissionSubGroup']);

    // private route with auth token
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('auth/profile', 'Auth\AuthController@profile');
        $router->post('auth/logout', 'Auth\AuthController@logout');
    });
});
