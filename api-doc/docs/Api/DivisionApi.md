# OpenAPI\Client\DivisionApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1DivisionsDivisionIdGet**](DivisionApi.md#apiV1DivisionsDivisionIdGet) | **GET** /api/v1/divisions/{divisionId} | get one
[**apiV1DivisionsGet**](DivisionApi.md#apiV1DivisionsGet) | **GET** /api/v1/divisions | get list
[**destroy**](DivisionApi.md#destroy) | **DELETE** /api/v1/divisions/{divisionId} | delete
[**store**](DivisionApi.md#store) | **POST** /api/v1/divisions | store
[**update**](DivisionApi.md#update) | **PUT** /api/v1/divisions/{divisionId} | update



## apiV1DivisionsDivisionIdGet

> apiV1DivisionsDivisionIdGet($division_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DivisionApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$division_id = 5; // int | 

try {
    $apiInstance->apiV1DivisionsDivisionIdGet($division_id);
} catch (Exception $e) {
    echo 'Exception when calling DivisionApi->apiV1DivisionsDivisionIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **division_id** | **int**|  |

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


## apiV1DivisionsGet

> apiV1DivisionsGet($page, $order, $title_en, $title_bn)

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DivisionApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$page = 56; // int | 
$order = 'order_example'; // string | 
$title_en = 'title_en_example'; // string | 
$title_bn = 'title_bn_example'; // string | 

try {
    $apiInstance->apiV1DivisionsGet($page, $order, $title_en, $title_bn);
} catch (Exception $e) {
    echo 'Exception when calling DivisionApi->apiV1DivisionsGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**|  | [optional]
 **order** | **string**|  | [optional]
 **title_en** | **string**|  | [optional]
 **title_bn** | **string**|  | [optional]

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


## destroy

> destroy($division_id)

delete

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DivisionApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$division_id = 2; // int | 

try {
    $apiInstance->destroy($division_id);
} catch (Exception $e) {
    echo 'Exception when calling DivisionApi->destroy: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **division_id** | **int**|  |

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


## store

> store($title_en, $title_bn, $bbs_code)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DivisionApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$title_en = Test Division; // string | 
$title_bn = টেস্টিং ডিস্ট্রিক্ট; // string | 
$bbs_code = 1; // string | 

try {
    $apiInstance->store($title_en, $title_bn, $bbs_code);
} catch (Exception $e) {
    echo 'Exception when calling DivisionApi->store: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **bbs_code** | **string**|  | [optional]

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


## update

> update($division_id, $title_en, $title_bn, $bbs_code)

update

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DivisionApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$division_id = 1; // int | 
$title_en = Test Division_update; // string | 
$title_bn = টেস্টিং ডিস্ট্রিক্ট _আপডেট; // string | 
$bbs_code = 1; // float | 

try {
    $apiInstance->update($division_id, $title_en, $title_bn, $bbs_code);
} catch (Exception $e) {
    echo 'Exception when calling DivisionApi->update: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **division_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **bbs_code** | **float**|  | [optional]

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

