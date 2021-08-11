# OpenAPI\Client\PermissionServiceApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1PermissionsGet**](PermissionServiceApi.md#apiV1PermissionsGet) | **GET** /api/v1/permissions | get list
[**apiV1PermissionsInstituteIdAssignPermissionsToInstitutePost**](PermissionServiceApi.md#apiV1PermissionsInstituteIdAssignPermissionsToInstitutePost) | **POST** /api/v1/permissions/{instituteId}/assign-permissions-to-institute | assign-permissions-to-organization
[**apiV1PermissionsPermissionIdPut**](PermissionServiceApi.md#apiV1PermissionsPermissionIdPut) | **PUT** /api/v1/permissions/{permissionId} | update
[**apiV1PermissionsPost**](PermissionServiceApi.md#apiV1PermissionsPost) | **POST** /api/v1/permissions | store
[**assignPermissionsToInstitute**](PermissionServiceApi.md#assignPermissionsToInstitute) | **POST** /api/v1/permissions/{organizationId}/assign-permissions-to-organization | assign-permissions-to-institute
[**destroy6**](PermissionServiceApi.md#destroy6) | **DELETE** /api/v1/permissions/{permissionId} | destroy
[**read1**](PermissionServiceApi.md#read1) | **GET** /api/v1/permissions/{permissionId} | get one



## apiV1PermissionsGet

> apiV1PermissionsGet()

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->apiV1PermissionsGet();
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->apiV1PermissionsGet: ', $e->getMessage(), PHP_EOL;
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


## apiV1PermissionsInstituteIdAssignPermissionsToInstitutePost

> apiV1PermissionsInstituteIdAssignPermissionsToInstitutePost($institute_id, $permissions_0, $permissions_1, $permissions_2)

assign-permissions-to-organization

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$institute_id = 1; // float | 
$permissions_0 = 2; // float | 
$permissions_1 = 4; // float | 
$permissions_2 = 5; // float | 

try {
    $apiInstance->apiV1PermissionsInstituteIdAssignPermissionsToInstitutePost($institute_id, $permissions_0, $permissions_1, $permissions_2);
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->apiV1PermissionsInstituteIdAssignPermissionsToInstitutePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **institute_id** | **float**|  |
 **permissions_0** | **float**|  | [optional]
 **permissions_1** | **float**|  | [optional]
 **permissions_2** | **float**|  | [optional]

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


## apiV1PermissionsPermissionIdPut

> apiV1PermissionsPermissionIdPut($permission_id, $name, $uri, $method)

update

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_id = 1; // int | 
$name = Can Add Updated; // string | 
$uri = can-add-updated; // string | 
$method = 1; // float | 

try {
    $apiInstance->apiV1PermissionsPermissionIdPut($permission_id, $name, $uri, $method);
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->apiV1PermissionsPermissionIdPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_id** | **int**|  |
 **name** | **string**|  |
 **uri** | **string**|  |
 **method** | **float**|  |

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


## apiV1PermissionsPost

> apiV1PermissionsPost($name, $uri, $method)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$name = Can Add; // string | 
$uri = can-add; // string | 
$method = 1; // float | 

try {
    $apiInstance->apiV1PermissionsPost($name, $uri, $method);
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->apiV1PermissionsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **name** | **string**|  |
 **uri** | **string**|  |
 **method** | **float**|  |

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


## assignPermissionsToInstitute

> assignPermissionsToInstitute($organization_id, $permissions_0, $permissions_1, $permissions_2)

assign-permissions-to-institute

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$organization_id = 1; // int | 
$permissions_0 = 1; // int | 
$permissions_1 = 2; // int | 
$permissions_2 = 3; // int | 

try {
    $apiInstance->assignPermissionsToInstitute($organization_id, $permissions_0, $permissions_1, $permissions_2);
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->assignPermissionsToInstitute: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **organization_id** | **int**|  |
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


## destroy6

> destroy6($permission_id)

destroy

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_id = 1; // int | 

try {
    $apiInstance->destroy6($permission_id);
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->destroy6: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_id** | **int**|  |

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


## read1

> read1($permission_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_id = 1; // int | 

try {
    $apiInstance->read1($permission_id);
} catch (Exception $e) {
    echo 'Exception when calling PermissionServiceApi->read1: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_id** | **int**|  |

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

