# OpenAPI\Client\RoleServicesApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1RolesGet**](RoleServicesApi.md#apiV1RolesGet) | **GET** /api/v1/roles | get list
[**apiV1RolesPost**](RoleServicesApi.md#apiV1RolesPost) | **POST** /api/v1/roles | store
[**apiV1RolesRoleIdAssignPermissionsPost**](RoleServicesApi.md#apiV1RolesRoleIdAssignPermissionsPost) | **POST** /api/v1/roles/{roleId}/assign-permissions | assign-permission
[**apiV1RolesRoleIdDelete**](RoleServicesApi.md#apiV1RolesRoleIdDelete) | **DELETE** /api/v1/roles/{roleId} | destroy
[**apiV1RolesRoleIdGet**](RoleServicesApi.md#apiV1RolesRoleIdGet) | **GET** /api/v1/roles/{roleId} | get one
[**apiV1RolesRoleIdPut**](RoleServicesApi.md#apiV1RolesRoleIdPut) | **PUT** /api/v1/roles/{roleId} | store



## apiV1RolesGet

> apiV1RolesGet()

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\RoleServicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $apiInstance->apiV1RolesGet();
} catch (Exception $e) {
    echo 'Exception when calling RoleServicesApi->apiV1RolesGet: ', $e->getMessage(), PHP_EOL;
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


## apiV1RolesPost

> apiV1RolesPost($title_en, $title_bn, $key, $description, $permission_group_id, $organization_id, $institute_id)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\RoleServicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$title_en = Editor; // string | 
$title_bn = সম্পাদক; // string | 
$key = editor; // string | 
$description = Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.; // string | 
$permission_group_id = 56; // int | 
$organization_id = 56; // int | 
$institute_id = 56; // int | 

try {
    $apiInstance->apiV1RolesPost($title_en, $title_bn, $key, $description, $permission_group_id, $organization_id, $institute_id);
} catch (Exception $e) {
    echo 'Exception when calling RoleServicesApi->apiV1RolesPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **key** | **string**|  |
 **description** | **string**|  | [optional]
 **permission_group_id** | **int**|  | [optional]
 **organization_id** | **int**|  | [optional]
 **institute_id** | **int**|  | [optional]

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


## apiV1RolesRoleIdAssignPermissionsPost

> apiV1RolesRoleIdAssignPermissionsPost($role_id, $permissions_0, $permissions_1, $permissions_2)

assign-permission

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\RoleServicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$role_id = 1; // int | 
$permissions_0 = 1; // string | 
$permissions_1 = 2; // string | 
$permissions_2 = 3; // string | 

try {
    $apiInstance->apiV1RolesRoleIdAssignPermissionsPost($role_id, $permissions_0, $permissions_1, $permissions_2);
} catch (Exception $e) {
    echo 'Exception when calling RoleServicesApi->apiV1RolesRoleIdAssignPermissionsPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  |
 **permissions_0** | **string**|  | [optional]
 **permissions_1** | **string**|  | [optional]
 **permissions_2** | **string**|  | [optional]

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


## apiV1RolesRoleIdDelete

> apiV1RolesRoleIdDelete($role_id)

destroy

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\RoleServicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$role_id = 1; // int | 

try {
    $apiInstance->apiV1RolesRoleIdDelete($role_id);
} catch (Exception $e) {
    echo 'Exception when calling RoleServicesApi->apiV1RolesRoleIdDelete: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
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


## apiV1RolesRoleIdGet

> apiV1RolesRoleIdGet($role_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\RoleServicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$role_id = 1; // int | 

try {
    $apiInstance->apiV1RolesRoleIdGet($role_id);
} catch (Exception $e) {
    echo 'Exception when calling RoleServicesApi->apiV1RolesRoleIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
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


## apiV1RolesRoleIdPut

> apiV1RolesRoleIdPut($role_id, $title_en, $title_bn, $key, $description, $permission_group_id, $organization_id, $institute_id)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\RoleServicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$role_id = 1; // int | 
$title_en = Editor_Updated; // string | 
$title_bn = সম্পাদক _ আপডেট; // string | 
$key = editor-updated; // string | 
$description = Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen bookআপডেট.; // string | 
$permission_group_id = 56; // int | 
$organization_id = 56; // int | 
$institute_id = 56; // int | 

try {
    $apiInstance->apiV1RolesRoleIdPut($role_id, $title_en, $title_bn, $key, $description, $permission_group_id, $organization_id, $institute_id);
} catch (Exception $e) {
    echo 'Exception when calling RoleServicesApi->apiV1RolesRoleIdPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **key** | **string**|  |
 **description** | **string**|  | [optional]
 **permission_group_id** | **int**|  | [optional]
 **organization_id** | **int**|  | [optional]
 **institute_id** | **int**|  | [optional]

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

