# OpenAPI\Client\UserServiceApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1UsersGet**](UserServiceApi.md#apiV1UsersGet) | **GET** /api/v1/users | get list
[**apiV1UsersPost**](UserServiceApi.md#apiV1UsersPost) | **POST** /api/v1/users | store
[**apiV1UsersUserIdAssignPermissionsPost**](UserServiceApi.md#apiV1UsersUserIdAssignPermissionsPost) | **POST** /api/v1/users/{userId}/assign-permissions | assign-permissions
[**apiV1UsersUserIdAssignRolePost**](UserServiceApi.md#apiV1UsersUserIdAssignRolePost) | **POST** /api/v1/users/{userId}/assign-role | assign-role
[**apiV1UsersUserIdDelete**](UserServiceApi.md#apiV1UsersUserIdDelete) | **DELETE** /api/v1/users/{userId} | delete
[**apiV1UsersUserIdGet**](UserServiceApi.md#apiV1UsersUserIdGet) | **GET** /api/v1/users/{userId} | get one
[**apiV1UsersUserIdPut**](UserServiceApi.md#apiV1UsersUserIdPut) | **PUT** /api/v1/users/{userId} | store



## apiV1UsersGet

> apiV1UsersGet()

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->apiV1UsersGet();
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

This endpoint does not need any parameter.

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## apiV1UsersPost

> apiV1UsersPost($name_en, $name_bn, $email, $loc_division_id, $loc_district_id, $loc_upazila_id, $password)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$name_en = Miladul Islam; // string | 
$name_bn = মিলাদুল ইসলাম; // string | 
$email = miladul@email.com; // string | 
$loc_division_id = 1; // int | 
$loc_district_id = 1; // int | 
$loc_upazila_id = 1; // int | 
$password = 12345678; // string | 

try {
    $apiInstance->apiV1UsersPost($name_en, $name_bn, $email, $loc_division_id, $loc_district_id, $loc_upazila_id, $password);
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **name_en** | **string**|  |
 **name_bn** | **string**|  |
 **email** | **string**|  |
 **loc_division_id** | **int**|  |
 **loc_district_id** | **int**|  |
 **loc_upazila_id** | **int**|  |
 **password** | **string**|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## apiV1UsersUserIdAssignPermissionsPost

> apiV1UsersUserIdAssignPermissionsPost($user_id, $permissions_0, $permissions_1, $permissions_2)

assign-permissions

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$user_id = 1; // int | 
$permissions_0 = 1; // int | 
$permissions_1 = 2; // int | 
$permissions_2 = 4; // int | 

try {
    $apiInstance->apiV1UsersUserIdAssignPermissionsPost($user_id, $permissions_0, $permissions_1, $permissions_2);
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersUserIdAssignPermissionsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |
 **permissions_0** | **int**|  |
 **permissions_1** | **int**|  |
 **permissions_2** | **int**|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## apiV1UsersUserIdAssignRolePost

> apiV1UsersUserIdAssignRolePost($user_id, $role_id)

assign-role

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$user_id = 1; // int | 
$role_id = 1; // int | 

try {
    $apiInstance->apiV1UsersUserIdAssignRolePost($user_id, $role_id);
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersUserIdAssignRolePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |
 **role_id** | **int**|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## apiV1UsersUserIdDelete

> apiV1UsersUserIdDelete($user_id)

delete

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$user_id = 1; // int | 

try {
    $apiInstance->apiV1UsersUserIdDelete($user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersUserIdDelete: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## apiV1UsersUserIdGet

> apiV1UsersUserIdGet($user_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$user_id = 1; // int | 

try {
    $apiInstance->apiV1UsersUserIdGet($user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersUserIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)


## apiV1UsersUserIdPut

> apiV1UsersUserIdPut($user_id, $name_en, $name_bn, $email, $loc_division_id, $loc_district_id, $loc_upazila_id, $password)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UserServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$user_id = 1; // int | 
$name_en = Miladul Islam_Updated; // string | 
$name_bn = মিলাদুল ইসলাম; // string | 
$email = miladul@email.com; // string | 
$loc_division_id = 1; // int | 
$loc_district_id = 1; // int | 
$loc_upazila_id = 1; // int | 
$password = 12345678; // string | 

try {
    $apiInstance->apiV1UsersUserIdPut($user_id, $name_en, $name_bn, $email, $loc_division_id, $loc_district_id, $loc_upazila_id, $password);
} catch (Exception $e) {
    echo 'Exception when calling UserServiceApi->apiV1UsersUserIdPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **int**|  |
 **name_en** | **string**|  |
 **name_bn** | **string**|  |
 **email** | **string**|  |
 **loc_division_id** | **int**|  |
 **loc_district_id** | **int**|  |
 **loc_upazila_id** | **int**|  |
 **password** | **string**|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)

