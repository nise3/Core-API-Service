<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Classes\CustomRouter;
$customRouter = function (string $as = '') use ($router) {
    $custom = new CustomRouter($router);
    return $custom->as($as);
};

$router->get('/hello', 'ExampleController@hateoasResponse');

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {
    /* Authentication related routes */
    $router->post('auth/login', 'Auth\AuthController@login');
    $router->post('auth/register', 'Auth\AuthController@register');

    /* division Crud Operation */
    $customRouter('divisions')->resourceRoute('divisions', 'LocDivisionController')->render();

    /* districts Crud Operation*/
    $customRouter('districts')->resourceRoute('districts', 'LocDistrictController')->render();

    /* Upazila Crud Operation*/
    $customRouter('upazilas')->resourceRoute('upazilas', 'LocUpazilaController')->render();

    // private route with auth token
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('auth/profile', 'Auth\AuthController@profile');
        $router->post('auth/logout', 'Auth\AuthController@logout');
    });
});
