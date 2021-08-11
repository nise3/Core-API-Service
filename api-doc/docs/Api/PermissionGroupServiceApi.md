# OpenAPI\Client\PermissionGroupServiceApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1PermissionGroupsPermissionGroupIdAssignPermissionsPost**](PermissionGroupServiceApi.md#apiV1PermissionGroupsPermissionGroupIdAssignPermissionsPost) | **POST** /api/v1/permission-groups/{permissionGroupId}/assign-permissions | assign-permission
[**apiV1PermissionGroupsPermissionGroupIdDelete**](PermissionGroupServiceApi.md#apiV1PermissionGroupsPermissionGroupIdDelete) | **DELETE** /api/v1/permission-groups/{permissionGroupId} | delete
[**apiV1PermissionGroupsPermissionGroupIdGet**](PermissionGroupServiceApi.md#apiV1PermissionGroupsPermissionGroupIdGet) | **GET** /api/v1/permission-groups/{permissionGroupId} | get one
[**apiV1PermissionGroupsPermissionGroupIdPut**](PermissionGroupServiceApi.md#apiV1PermissionGroupsPermissionGroupIdPut) | **PUT** /api/v1/permission-groups/{permissionGroupId} | update
[**apiV1PermissionGroupsPost**](PermissionGroupServiceApi.md#apiV1PermissionGroupsPost) | **POST** /api/v1/permission-groups | create
[**getList0**](PermissionGroupServiceApi.md#getList0) | **GET** /api/v1/permission-groups | get list



## apiV1PermissionGroupsPermissionGroupIdAssignPermissionsPost

> apiV1PermissionGroupsPermissionGroupIdAssignPermissionsPost($permission_group_id, $permissions_0, $permissions_1, $permissions_2)

assign-permission

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_group_id = 1; // int | 
$permissions_0 = 1; // int | 
$permissions_1 = 3; // int | 
$permissions_2 = 5; // int | 

try {
    $apiInstance->apiV1PermissionGroupsPermissionGroupIdAssignPermissionsPost($permission_group_id, $permissions_0, $permissions_1, $permissions_2);
} catch (Exception $e) {
    echo 'Exception when calling PermissionGroupServiceApi->apiV1PermissionGroupsPermissionGroupIdAssignPermissionsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_group_id** | **int**|  |
 **permissions_0** | **int**|  | [optional]
 **permissions_1** | **int**|  | [optional]
 **permissions_2** | **int**|  | [optional]

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


## apiV1PermissionGroupsPermissionGroupIdDelete

> apiV1PermissionGroupsPermissionGroupIdDelete($permission_group_id)

delete

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_group_id = 1; // int | 

try {
    $apiInstance->apiV1PermissionGroupsPermissionGroupIdDelete($permission_group_id);
} catch (Exception $e) {
    echo 'Exception when calling PermissionGroupServiceApi->apiV1PermissionGroupsPermissionGroupIdDelete: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_group_id** | **int**|  |

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


## apiV1PermissionGroupsPermissionGroupIdGet

> apiV1PermissionGroupsPermissionGroupIdGet($permission_group_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_group_id = 1; // int | 

try {
    $apiInstance->apiV1PermissionGroupsPermissionGroupIdGet($permission_group_id);
} catch (Exception $e) {
    echo 'Exception when calling PermissionGroupServiceApi->apiV1PermissionGroupsPermissionGroupIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_group_id** | **int**|  |

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


## apiV1PermissionGroupsPermissionGroupIdPut

> apiV1PermissionGroupsPermissionGroupIdPut($permission_group_id, $title_en, $title_bn, $key)

update

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_group_id = 1; // int | 
$title_en = Permission Group1_updated; // string | 
$title_bn = পারমিশন গ্রুপঃ১; // string | 
$key = permission-group1; // string | 

try {
    $apiInstance->apiV1PermissionGroupsPermissionGroupIdPut($permission_group_id, $title_en, $title_bn, $key);
} catch (Exception $e) {
    echo 'Exception when calling PermissionGroupServiceApi->apiV1PermissionGroupsPermissionGroupIdPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_group_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **key** | **string**|  |

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


## apiV1PermissionGroupsPost

> apiV1PermissionGroupsPost($title_en, $title_bn, $key)

create

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$title_en = Permission Group1; // string | 
$title_bn = পারমিশন গ্রুপঃ১; // string | 
$key = permission-group1; // string | 

try {
    $apiInstance->apiV1PermissionGroupsPost($title_en, $title_bn, $key);
} catch (Exception $e) {
    echo 'Exception when calling PermissionGroupServiceApi->apiV1PermissionGroupsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **key** | **string**|  |

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


## getList0

> getList0()

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->getList0();
} catch (Exception $e) {
    echo 'Exception when calling PermissionGroupServiceApi->getList0: ', $e->getMessage(), PHP_EOL;
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

