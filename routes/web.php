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

$router->get('/apim-app-oauth2-access-token', ['as' => 'apim-app-oauth2-access-token', 'uses' => 'BackChannelTokenGenerationController@apimAppApiAccessToken']);
$router->post('/sso-authorize-code-grant', ['as' => 'sso-authorize-code-grant', 'uses' => 'BackChannelTokenGenerationController@ssoAuthorizeCodeGrant']);
$router->post('/sso-renew-access-token', ['as' => 'sso-renew-access-token', 'uses' => 'BackChannelTokenGenerationController@ssoRenewAccessToken']);

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {

    $router->get('/', ['uses' => 'ApiInfoController@apiInfo']);

    // private routes
    $router->group(['middleware' => 'auth'], function () use ($router, $customRouter) {
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

        $router->put('users/{id}/password-update', ['as' => 'users.profile-update', 'uses' => 'UserController@updatePassword']);



        /* assign permission to permission group*/
        $router->post('permission-groups/{id}/assign-permissions', ['as' => 'permission-groups.assign-permissions', 'uses' => 'PermissionGroupController@assignPermissionToPermissionGroup']);

        /* assign permission to permission group*/
        $router->post('permission-sub-groups/{id}/assign-permissions', ['as' => 'permission-sub-groups.assign-permissions', 'uses' => 'PermissionSubGroupController@assignPermissionToPermissionSubGroup']);

    });

    //Service to service direct call without any authorization and authentication
    $router->group(['prefix' => 'service-to-service-call', 'as' => 'service-to-service-call'], function () use ($router) {
        /** domain Fetch  */
        $router->get("domain-identification", ["as" => "service-to-service-call.domain-identification", "uses" => "ApiInfoController@domainDetails"]);
        $router->get("domain", ["as" => "service-to-service-call.domain", "uses" => "ApiInfoController@getDomain"]);

        /** Permission subgroup by title */
        $router->get("permission-sub-group/{title}", ["as" => "service-to-service-call.permission-sub-group", "uses" => "PermissionSubGroupController@getByTitle"]);

        /** Get user by username */
        $router->get("user-by-username/{username}", ["as" => "service-to-service-call.user-by-username", "uses" => "UserController@getByUsername"]);

        /** Get user by username */
        $router->post("create-trainer-user", ["as" => "service-to-service-call.create-trainer-user", "uses" => "UserController@trainerYouthUserCreate"]);

        /** Create 4IR user */
        $router->post("create-four-ir-user", ["as" => "service-to-service-call.create-four-ir-user", "uses" => "UserController@fourIrUserCreate"]);
        $router->put("update-four-ir-user", ["as" => "service-to-service-call.update-four-ir-user", "uses" => "UserController@fourIrUserUpdate"]);
        $router->delete("delete-four-ir-user", ["as" => "service-to-service-call.delete-four-ir-user", "uses" => "UserController@fourIrUserDelete"]);
    });

    $router->put('user-approval', ['as' => 'users.user-approval', 'uses' => 'UserController@userApproval']);

    $router->put('user-rejection', ['as' => 'users.user-rejection', 'uses' => 'UserController@userRejection']);

    /** Delete user created from Organization ,institute and industryAssociation */
    $router->delete('user-delete', ['as' => 'users.user-delete', 'uses' => 'UserController@userDestroy']);


    /** Auth user info Call from other service*/
    $router->post("auth-user-info", ["as" => "users.auth-user-info", "uses" => "UserController@getAuthUserInfoByIdpId"]);

    /** Organization,institute and industry Association User create by admin from other service */
    $router->post('admin-user-create', ['as' => 'admin-user-create', 'uses' => 'UserController@adminUserCreate']);

    /** User open Registration from Organization,institute and industry Association from other service */
    $router->post('user-open-registration', ['as' => 'users.register-users', 'uses' => 'UserController@userOpenRegistration']);


    /** Forget Password */
    $router->post('send-forget-password-otp', ['as' => 'users.send-forget-password-otp', 'uses' => 'UserController@sendForgetPasswordOtp']);
    $router->post('verify-forget-password-otp', ['as' => 'users.verify-forget-password-otp', 'uses' => 'UserController@verifyForgetPasswordOtp']);
    $router->post('reset-forget-password', ['as' => 'users.reset-forget-password', 'uses' => 'UserController@resetForgetPassword']);
    $router->get('roles-for-4IR', ['as' => 'roles.roles-for-4IR', 'uses' => 'RoleController@getRolesForFourIR']);

    $router->get("domain-details", ["as" => "domain-details", "uses" => "ApiInfoController@domainDetails"]);


});



