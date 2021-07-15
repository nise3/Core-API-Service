<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Classes\CustomRouter;

$customRouter = function (string $as = '') use ($router) {
    $custom = new CustomRouter($router);
    return $custom->as($as);
};

$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {
    $router->post('auth/login', 'Auth\AuthController@login');
    $router->post('auth/register', 'Auth\AuthController@register');

    $customRouter('divisions')->resourceRoute('divisions', 'LocDivisionController')->render();
    $customRouter()->resourceRoute('districts', 'LocDistrictController')->render();
    $customRouter()->resourceRoute('upazilas', 'LocUpazilaController')->render();

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
