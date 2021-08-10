# OpenAPI\Client\UpazilaApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1UpazilasGet**](UpazilaApi.md#apiV1UpazilasGet) | **GET** /api/v1/upazilas | get-list
[**apiV1UpazilasPost**](UpazilaApi.md#apiV1UpazilasPost) | **POST** /api/v1/upazilas | store
[**apiV1UpazilasUpazilaIdDelete**](UpazilaApi.md#apiV1UpazilasUpazilaIdDelete) | **DELETE** /api/v1/upazilas/{upazilaId} | destroy
[**apiV1UpazilasUpazilaIdGet**](UpazilaApi.md#apiV1UpazilasUpazilaIdGet) | **GET** /api/v1/upazilas/{upazilaId} | get one
[**apiV1UpazilasUpazilaIdPut**](UpazilaApi.md#apiV1UpazilasUpazilaIdPut) | **PUT** /api/v1/upazilas/{upazilaId} | update



## apiV1UpazilasGet

> apiV1UpazilasGet($page, $order, $title_en, $title_bn, $loc_division_id, $loc_district_id)

get-list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UpazilaApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$page = 56; // int | 
$order = 'order_example'; // string | 
$title_en = 'title_en_example'; // string | 
$title_bn = 'title_bn_example'; // string | 
$loc_division_id = 56; // int | 
$loc_district_id = 56; // int | 

try {
    $apiInstance->apiV1UpazilasGet($page, $order, $title_en, $title_bn, $loc_division_id, $loc_district_id);
} catch (Exception $e) {
    echo 'Exception when calling UpazilaApi->apiV1UpazilasGet: ', $e->getMessage(), PHP_EOL;
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
 **loc_division_id** | **int**|  | [optional]
 **loc_district_id** | **int**|  | [optional]

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


## apiV1UpazilasPost

> apiV1UpazilasPost($loc_division_id, $loc_district_id, $title_en, $title_bn, $division_bbs_code, $district_bbs_code, $bbs_code)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UpazilaApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$loc_division_id = 1; // int | 
$loc_district_id = 1; // int | 
$title_en = New Upazila; // string | 
$title_bn = নিউ উপজিলা; // string | 
$division_bbs_code = 10; // string | 
$district_bbs_code = 100; // string | 
$bbs_code = 1000; // float | 

try {
    $apiInstance->apiV1UpazilasPost($loc_division_id, $loc_district_id, $title_en, $title_bn, $division_bbs_code, $district_bbs_code, $bbs_code);
} catch (Exception $e) {
    echo 'Exception when calling UpazilaApi->apiV1UpazilasPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **loc_division_id** | **int**|  |
 **loc_district_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **division_bbs_code** | **string**|  | [optional]
 **district_bbs_code** | **string**|  | [optional]
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


## apiV1UpazilasUpazilaIdDelete

> apiV1UpazilasUpazilaIdDelete($upazila_id)

destroy

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UpazilaApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$upazila_id = 1; // int | 

try {
    $apiInstance->apiV1UpazilasUpazilaIdDelete($upazila_id);
} catch (Exception $e) {
    echo 'Exception when calling UpazilaApi->apiV1UpazilasUpazilaIdDelete: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **upazila_id** | **int**|  |

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


## apiV1UpazilasUpazilaIdGet

> apiV1UpazilasUpazilaIdGet($upazila_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UpazilaApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$upazila_id = 1; // int | 

try {
    $apiInstance->apiV1UpazilasUpazilaIdGet($upazila_id);
} catch (Exception $e) {
    echo 'Exception when calling UpazilaApi->apiV1UpazilasUpazilaIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **upazila_id** | **int**|  |

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


## apiV1UpazilasUpazilaIdPut

> apiV1UpazilasUpazilaIdPut($upazila_id, $loc_division_id, $loc_district_id, $title_en, $title_bn, $division_bbs_code, $district_bbs_code, $bbs_code)

update

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\UpazilaApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$upazila_id = 1; // int | 
$loc_division_id = 1; // int | 
$loc_district_id = 1; // int | 
$title_en = New Upazila _Update; // string | 
$title_bn = নিউ উপজিলা_আপডেট; // string | 
$division_bbs_code = 10; // float | 
$district_bbs_code = 100; // float | 
$bbs_code = 1000; // string | 

try {
    $apiInstance->apiV1UpazilasUpazilaIdPut($upazila_id, $loc_division_id, $loc_district_id, $title_en, $title_bn, $division_bbs_code, $district_bbs_code, $bbs_code);
} catch (Exception $e) {
    echo 'Exception when calling UpazilaApi->apiV1UpazilasUpazilaIdPut: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **upazila_id** | **int**|  |
 **loc_division_id** | **int**|  |
 **loc_district_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **division_bbs_code** | **float**|  | [optional]
 **district_bbs_code** | **float**|  | [optional]
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

