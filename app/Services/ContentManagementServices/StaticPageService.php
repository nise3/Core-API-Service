<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\StaticPage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class StaticPageService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllStaticPages(array $request, Carbon $startTime): array
    {
        $titleEn = array_key_exists('title_en', $request) ? $request['title_en'] : "";
        $titleBn = array_key_exists('title_bn', $request) ? $request['title_bn'] : "";
        $paginate = array_key_exists('page', $request) ? $request['page'] : "";
        $pageSize = array_key_exists('page_size', $request) ? $request['page_size'] : "";
        $rowStatus = array_key_exists('row_status', $request) ? $request['row_status'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";

        /** @var Builder $staticPageBuilder */
        $staticPageBuilder = StaticPage::select([
            'static_pages.id',
            'static_pages.title_en',
            'static_pages.title_bn',
            'static_pages.institute_id',
            'static_pages.page_id',
            'static_pages.page_contents',
            'static_pages.created_by',
            'static_pages.created_at',
            'static_pages.updated_at'
        ]);
        $staticPageBuilder->orderBy('static_pages.id', $order);

        if (is_numeric($rowStatus)) {
            $staticPageBuilder->where('static_pages.row_status', $rowStatus);
        }

        /** @var Collection $staticPages */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $staticPages = $staticPageBuilder->paginate($pageSize);
            $paginateData = (object)$staticPages->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $staticPages = $staticPageBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $staticPages->toArray()['data'] ?? $staticPages->toArray();
        $response['response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];
        return $response;
    }

    /**
     * @param int $id
     * @param Carbon $startTime
     * @return array
     */
    public function getOneStaticPage(int $id, Carbon $startTime): array
    {
        /** @var Builder $staticPageBuilder */
        $staticPageBuilder = StaticPage::select([
            'static_pages.id',
            'static_pages.title_en',
            'static_pages.title_bn',
            'static_pages.institute_id',
            'static_pages.page_id',
            'static_pages.page_contents',
            'static_pages.created_by',
            'static_pages.created_at',
            'static_pages.updated_at'
        ]);
        $staticPageBuilder->where('static_pages.id', $id);


        /** @var StaticPage $staticPage */
        $staticPage = $staticPageBuilder->first();

        return [
            "data" => $staticPage ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }

    /**
     * @param array $data
     * @return StaticPage
     */
    public function store(array $data): StaticPage
    {
        $staticPage = new StaticPage();
        $staticPage->fill($data);
        $staticPage->save();
        return $staticPage;
    }


    /**
     * @param StaticPage $staticPage
     * @param array $data
     * @return StaticPage
     */
    public function update(StaticPage $staticPage, array $data): StaticPage
    {
        $staticPage->fill($data);
        $staticPage->save();
        return $staticPage;
    }

    /**
     * @param StaticPage $staticPage
     * @return bool
     */
    public function destroy(StaticPage $staticPage): bool
    {
        return $staticPage->delete();
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191'
            ],
            'title_bn' => [
                'required',
                'string',
                'max:191'
            ],
            'institute_id' => [
                'bail',
                'required',
                'int',
            ],
            'page_id' => [
                'required',
                'string',
                'max:191',
                'regex:/^[a-zA-Z0-9-_]/',
            ],
            'page_contents' => [
                'required',
                'string',
                'max:5000'
            ],
        ];

        return Validator::make($request->all(), $rules);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC',
            'row_status.in' => 'Row status must be within 1 or 0'
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|min:1',
            'title_bn' => 'nullable|min:1',
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
