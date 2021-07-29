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
    $customRouter()->resourceRoute('roles', 'RoleController')->render();
    $customRouter()->resourceRoute('permission-groups', 'PermissionGroupController')->render();
    $customRouter()->resourceRoute('permission-sub-groups', 'PermissionSubGroupController')->render();
    $customRouter()->resourceRoute('users', 'UserController')->render();


    /* assign permission to Roles*/
    $router->post('roles/{id}/assign-permissions', ['as' => 'roles.assign-permissions', 'uses' => 'RoleController@assignPermissionToRole']);

    /* assign permission to organizations*/
    $router->post('permissions/{id}/assign-permissions', ['as' => 'permissions.assign-permissions-to-organization', 'uses' => 'PermissionController@assignPermissionToOrganization']);

    /* assign permission to Institutes*/
    $router->post('permissions/{id}/assign-permissions', ['as' => 'permissions.assign-permissions-to-institute', 'uses' => 'PermissionController@assignPermissionToInstitute']);

    /* assign permission to permission group*/
    $router->post('permission-groups/{id}/assign-permissions', ['as' => 'permission-groups.assign-permissions', 'uses' => 'PermissionGroupController@assignPermissionToPermissionGroup']);

    /* assign permission to permission group*/
    $router->post('permission-sub-groups/{id}/assign-permissions', ['as' => 'permission-sub-groups.assign-permissions', 'uses' => 'PermissionSubGroupController@assignPermissionToPermissionSubGroup']);

    // private route with auth token
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('auth/profile', 'Auth\AuthController@profile');
        $router->post('auth/logout', 'Auth\AuthController@logout');
    });

});
