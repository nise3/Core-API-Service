# OpenAPI\Client\DistrictApi

All URIs are relative to *http://localhost:8000*

Method | HTTP request | Description
------------- | ------------- | -------------
[**apiV1DistrictsDistrictIdGet**](DistrictApi.md#apiV1DistrictsDistrictIdGet) | **GET** /api/v1/districts/{districtId} | get one
[**apiV1DistrictsGet**](DistrictApi.md#apiV1DistrictsGet) | **GET** /api/v1/districts | get list
[**destroy1**](DistrictApi.md#destroy1) | **DELETE** /api/v1/districts/{districtId} | destroy
[**store2**](DistrictApi.md#store2) | **POST** /api/v1/districts | store
[**update3**](DistrictApi.md#update3) | **PUT** /api/v1/districts/{districtId} | update



## apiV1DistrictsDistrictIdGet

> apiV1DistrictsDistrictIdGet($district_id)

get one

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DistrictApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$district_id = 1; // int | 

try {
    $apiInstance->apiV1DistrictsDistrictIdGet($district_id);
} catch (Exception $e) {
    echo 'Exception when calling DistrictApi->apiV1DistrictsDistrictIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **district_id** | **int**|  |

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


## apiV1DistrictsGet

> apiV1DistrictsGet($page, $order, $title_en, $title_bn, $loc_division_id)

get list

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DistrictApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$page = 56; // int | 
$order = 'order_example'; // string | 
$title_en = 'title_en_example'; // string | 
$title_bn = 'title_bn_example'; // string | 
$loc_division_id = 56; // int | 

try {
    $apiInstance->apiV1DistrictsGet($page, $order, $title_en, $title_bn, $loc_division_id);
} catch (Exception $e) {
    echo 'Exception when calling DistrictApi->apiV1DistrictsGet: ', $e->getMessage(), PHP_EOL;
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


## destroy1

> destroy1($district_id)

destroy

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DistrictApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$district_id = 1; // int | 

try {
    $apiInstance->destroy1($district_id);
} catch (Exception $e) {
    echo 'Exception when calling DistrictApi->destroy1: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **district_id** | **int**|  |

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


## store2

> store2($loc_division_id, $title_en, $title_bn, $division_bbs_code, $bbs_code)

store

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DistrictApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$loc_division_id = 1; // int | 
$title_en = Test District; // string | 
$title_bn = টেস্টিং জেলা; // string | 
$division_bbs_code = 10; // float | 
$bbs_code = 100; // string | 

try {
    $apiInstance->store2($loc_division_id, $title_en, $title_bn, $division_bbs_code, $bbs_code);
} catch (Exception $e) {
    echo 'Exception when calling DistrictApi->store2: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **loc_division_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **division_bbs_code** | **float**|  | [optional]
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


## update3

> update3($district_id, $loc_division_id, $title_en, $title_bn, $division_bbs_code, $bbs_code)

update

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\DistrictApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$district_id = 1; // int | 
$loc_division_id = 1; // int | 
$title_en = Test District _ Update; // string | 
$title_bn = টেস্টিং জেলা_আপডেট; // string | 
$division_bbs_code = 10; // float | 
$bbs_code = 100; // string | 

try {
    $apiInstance->update3($district_id, $loc_division_id, $title_en, $title_bn, $division_bbs_code, $bbs_code);
} catch (Exception $e) {
    echo 'Exception when calling DistrictApi->update3: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **district_id** | **int**|  |
 **loc_division_id** | **int**|  |
 **title_en** | **string**|  |
 **title_bn** | **string**|  |
 **division_bbs_code** | **float**|  | [optional]
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

