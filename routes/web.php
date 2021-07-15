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
    $customRouter()->resourceRoute('permissions', 'PermissionController')->render();
    $customRouter()->resourceRoute('permission-groups', 'PermissionGroupController')->render();

    /* assign permission to organizations*/
    $router->post('permissions/assign-permissions-to-organization/{organization_id}', ['as' => 'permissions.assign-permissions-to-organization', 'uses' => 'PermissionController@assignPermissionToOrganization']);

    /* assign permission to Institutes*/
    $router->post('permissions/assign-permissions-to-institute/{institute_id}', ['as' => 'permissions.assign-permissions-to-institute', 'uses' => 'PermissionController@assignPermissionToInstitute']);

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

    /* Role Crud Operation*/
    $router->get('roles', ['as' => 'roles.get-list', 'uses' => 'RoleController@getList']);
    $router->post('roles', ['as' => 'roles.store', 'uses' => 'RoleController@store']);
    $router->get('roles/{id}', ['as' => 'roles.read', 'uses' => 'RoleController@read']);
    $router->put('roles/{id}', ['as' => 'roles.update', 'uses' => 'RoleController@update']);
    $router->delete('roles/{id}', ['as' => 'roles.destroy', 'uses' => 'RoleController@destroy']);
});
