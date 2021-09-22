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
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

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

        if (!empty($titleEn)) {
            $staticPageBuilder->where('static_pages.title', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $staticPageBuilder->where('static_pages.sub_title', 'like', '%' . $titleBn . '%');
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
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'title_bn' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'institute_id' => [
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
                'string'
            ],
        ];

        return Validator::make($request->all(), $rules, $customMessage);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|string|max:191|min:2',
            'title_bn' => 'nullable|string|max:500|min:2',
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric|gt:0',
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
