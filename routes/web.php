<?php

/** @var Router $router */

use App\Helpers\Classes\CustomRouter;
use Laravel\Lumen\Routing\Router;

$customRouter = function (string $as = '') use ($router) {
    $custom = new CustomRouter($router);
    return $custom->as($as);
};

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/apim-app-oauth2-access-token', ['as' => 'nise3-app-api-access-token', 'uses' => 'BackChannelTokenGenerationController@apimAppApiAccessToken']);
$router->post('/sso-authorize-code-grant', ['as' => 'sso-authorize-code-grant', 'uses' => 'BackChannelTokenGenerationController@ssoAuthorizeCodeGrant']);
$router->post('/sso-renew-access-token', ['as' => 'sso-renew-access-token', 'uses' => 'BackChannelTokenGenerationController@ssoRenewAccessToken']);

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {

    $router->get('/', ['uses' => 'ApiInfoController@apiInfo']);


    $router->post('auth/login', 'Auth\AuthController@login');
    $router->post('auth/register', 'Auth\AuthController@register');

    $router->get('url', function () {
        echo url();
    });

    /* assign permission to organizations*/
    $router->post('permissions/{organization_id}/assign-permissions-to-organization', ['as' => 'permissions.assign-permissions-to-organization', 'uses' => 'PermissionController@assignPermissionToOrganization']);

    /* assign permission to Institutes*/
    $router->post('permissions/{institute_id}/assign-permissions-to-institute', ['as' => 'permissions.assign-permissions-to-institute', 'uses' => 'PermissionController@assignPermissionToInstitute']);


    $customRouter()->resourceRoute('permissions', 'PermissionController')->render();
    $customRouter()->resourceRoute('roles', 'RoleController')->render();
    $customRouter()->resourceRoute('permission-groups', 'PermissionGroupController')->render();
    $customRouter()->resourceRoute('permission-sub-groups', 'PermissionSubGroupController')->render();
    $customRouter()->resourceRoute('users', 'UserController')->render();

    $customRouter()->resourceRoute('menus', 'MenuController')->render();
    $customRouter()->resourceRoute('menu-items', 'MenuItemController')->render();

    /* assign permission to Roles*/
    $router->post('roles/{id}/assign-permissions', ['as' => 'roles.assign-permissions', 'uses' => 'RoleController@assignPermissionToRole']);

    $router->post('users/{id}/assign-permissions', ['as' => 'users.assign-permissions', 'uses' => 'UserController@assignPermissionToUser']);

    $router->post('users/{id}/assign-role', ['as' => 'users.assign-role', 'uses' => 'UserController@assignRoleToUser']);

    $router->get('users/{id}/permissions', ['as' => 'users.permissions', 'uses' => 'UserController@getUserPermissionList']);

    $router->post('users/{id}/profile-update', ['as' => 'users.profile-update', 'uses' => 'UserController@updateProfile']);

    $router->put('user-approval', ['as' => 'users.user-approval', 'uses' => 'UserController@userApproval']);

    $router->put('user-rejection', ['as' => 'users.user-rejection', 'uses' => 'UserController@userRejection']);

    /** Delete user created from Organization ,institute and industryAssociation */
    $router->delete('user-delete', ['as' => 'users.user-delete', 'uses' => 'UserController@userDestroy']);


    /** Auth user info */
    $router->post("auth-user-info", ["as" => "users.auth-user-info", "uses" => "UserController@getAuthUserInfoByIdpId"]);


    /* assign permission to permission group*/
    $router->post('permission-groups/{id}/assign-permissions', ['as' => 'permission-groups.assign-permissions', 'uses' => 'PermissionGroupController@assignPermissionToPermissionGroup']);

    /* assign permission to permission group*/
    $router->post('permission-sub-groups/{id}/assign-permissions', ['as' => 'permission-sub-groups.assign-permissions', 'uses' => 'PermissionSubGroupController@assignPermissionToPermissionSubGroup']);

    // private route with auth token
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('auth/profile', 'Auth\AuthController@profile');
        $router->post('auth/logout', 'Auth\AuthController@logout');
    });
    /** Organization,institute and industry Association User create by admin  */
    $router->post('admin-user-create', ['as' => 'admin-user-create', 'uses' => 'UserController@adminUserCreate']);

    /** User open Registration from Organization,institute and industry Association */
    $router->post('user-open-registration', ['as' => 'users.register-users', 'uses' => 'UserController@userOpenRegistration']);


});
