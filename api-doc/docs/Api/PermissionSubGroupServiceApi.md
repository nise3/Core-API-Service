# OpenAPI\Client\PermissionSubGroupServiceApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1PermissionSubGroupsGet**](PermissionSubGroupServiceApi.md#apiV1PermissionSubGroupsGet) | **GET** /api/v1/permission-sub-groups | get list
[**apiV1PermissionSubGroupsPermissionSubGroupIdAssignPermissionsPost**](PermissionSubGroupServiceApi.md#apiV1PermissionSubGroupsPermissionSubGroupIdAssignPermissionsPost) | **POST** /api/v1/permission-sub-groups/{permissionSubGroupId}/assign-permissions | assign-permission
[**apiV1PermissionSubGroupsPermissionSubGroupIdDelete**](PermissionSubGroupServiceApi.md#apiV1PermissionSubGroupsPermissionSubGroupIdDelete) | **DELETE** /api/v1/permission-sub-groups/{permissionSubGroupId} | delete
[**apiV1PermissionSubGroupsPermissionSubGroupIdGet**](PermissionSubGroupServiceApi.md#apiV1PermissionSubGroupsPermissionSubGroupIdGet) | **GET** /api/v1/permission-sub-groups/{permissionSubGroupId} | get one
[**apiV1PermissionSubGroupsPost**](PermissionSubGroupServiceApi.md#apiV1PermissionSubGroupsPost) | **POST** /api/v1/permission-sub-groups | create
[**update4**](PermissionSubGroupServiceApi.md#update4) | **PUT** /api/v1/permission-sub-groups/{permissionSubGroupId} | update



## apiV1PermissionSubGroupsGet

> apiV1PermissionSubGroupsGet()

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionSubGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->apiV1PermissionSubGroupsGet();
} catch (Exception $e) {
    echo 'Exception when calling PermissionSubGroupServiceApi->apiV1PermissionSubGroupsGet: ', $e->getMessage(), PHP_EOL;
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


## apiV1PermissionSubGroupsPermissionSubGroupIdAssignPermissionsPost

> apiV1PermissionSubGroupsPermissionSubGroupIdAssignPermissionsPost($permission_sub_group_id, $permissions_0, $permissions_1, $permissions_2)

assign-permission

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionSubGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_sub_group_id = 1; // int | 
$permissions_0 = 1; // int | 
$permissions_1 = 3; // int | 
$permissions_2 = 5; // int | 

try {
    $apiInstance->apiV1PermissionSubGroupsPermissionSubGroupIdAssignPermissionsPost($permission_sub_group_id, $permissions_0, $permissions_1, $permissions_2);
} catch (Exception $e) {
    echo 'Exception when calling PermissionSubGroupServiceApi->apiV1PermissionSubGroupsPermissionSubGroupIdAssignPermissionsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_sub_group_id** | **int**|  |
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


## apiV1PermissionSubGroupsPermissionSubGroupIdDelete

> apiV1PermissionSubGroupsPermissionSubGroupIdDelete($permission_sub_group_id)

delete

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionSubGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_sub_group_id = 1; // int | 

try {
    $apiInstance->apiV1PermissionSubGroupsPermissionSubGroupIdDelete($permission_sub_group_id);
} catch (Exception $e) {
    echo 'Exception when calling PermissionSubGroupServiceApi->apiV1PermissionSubGroupsPermissionSubGroupIdDelete: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_sub_group_id** | **int**|  |

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


## apiV1PermissionSubGroupsPermissionSubGroupIdGet

> apiV1PermissionSubGroupsPermissionSubGroupIdGet($permission_sub_group_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionSubGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_sub_group_id = 1; // int | 

try {
    $apiInstance->apiV1PermissionSubGroupsPermissionSubGroupIdGet($permission_sub_group_id);
} catch (Exception $e) {
    echo 'Exception when calling PermissionSubGroupServiceApi->apiV1PermissionSubGroupsPermissionSubGroupIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_sub_group_id** | **int**|  |

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


## apiV1PermissionSubGroupsPost

> apiV1PermissionSubGroupsPost($permission_group_id, $title_en, $title_bn, $key)

create

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionSubGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_group_id = 1; // int | 
$title_en = Permission Sub Group1; // string | 
$title_bn = পারমিশন সাব গ্রুপ ১; // string | 
$key = permission-sub-group-key; // string | 

try {
    $apiInstance->apiV1PermissionSubGroupsPost($permission_group_id, $title_en, $title_bn, $key);
} catch (Exception $e) {
    echo 'Exception when calling PermissionSubGroupServiceApi->apiV1PermissionSubGroupsPost: ', $e->getMessage(), PHP_EOL;
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


## update4

> update4($permission_sub_group_id, $permission_group_id, $title_en, $title_bn, $key)

update

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\PermissionSubGroupServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$permission_sub_group_id = 1; // int | 
$permission_group_id = 1; // int | 
$title_en = Permission Sub Group1_Update; // string | 
$title_bn = পারমিশন সাব গ্রুপ ১; // string | 
$key = permission-sub-group-key-updated; // string | 

try {
    $apiInstance->update4($permission_sub_group_id, $permission_group_id, $title_en, $title_bn, $key);
} catch (Exception $e) {
    echo 'Exception when calling PermissionSubGroupServiceApi->update4: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **permission_sub_group_id** | **int**|  |
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

