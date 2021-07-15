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

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('auth/profile', 'Auth\AuthController@profile');
        $router->post('auth/logout', 'Auth\AuthController@logout');
    });
});
