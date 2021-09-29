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
            'static_pages_and_block.id',
            'static_pages_and_block.title_en',
            'static_pages_and_block.title_bn',
            'static_pages_and_block.type',
            'static_pages_and_block.institute_id',
            'static_pages_and_block.organization_id',
            'static_pages_and_block.description_en',
            'static_pages_and_block.description_bn',
            'static_pages_and_block.page_id',
            'static_pages_and_block.page_contents',
            'static_pages_and_block.content_type',
            'static_pages_and_block.content_properties',
            'static_pages_and_block.content_path',
            'static_pages_and_block.alt_title_en',
            'static_pages_and_block.alt_title_bn',
            'static_pages_and_block.row_status',
            'static_pages_and_block.created_by',
            'static_pages_and_block.updated_by',
            'static_pages_and_block.created_at',
            'static_pages_and_block.updated_at'
        ]);
        $staticPageBuilder->orderBy('static_pages_and_block.id', $order);

        if (is_numeric($rowStatus)) {
            $staticPageBuilder->where('static_pages_and_block.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $staticPageBuilder->where('static_pages_and_block.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $staticPageBuilder->where('static_pages_and_block.title_bn', 'like', '%' . $titleBn . '%');
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
            'static_pages_and_block.id',
            'static_pages_and_block.title_en',
            'static_pages_and_block.title_bn',
            'static_pages_and_block.type',
            'static_pages_and_block.institute_id',
            'static_pages_and_block.organization_id',
            'static_pages_and_block.description_en',
            'static_pages_and_block.description_bn',
            'static_pages_and_block.page_id',
            'static_pages_and_block.page_contents',
            'static_pages_and_block.content_type',
            'static_pages_and_block.content_properties',
            'static_pages_and_block.content_path',
            'static_pages_and_block.alt_title_en',
            'static_pages_and_block.alt_title_bn',
            'static_pages_and_block.row_status',
            'static_pages_and_block.created_by',
            'static_pages_and_block.updated_by',
            'static_pages_and_block.created_at',
            'static_pages_and_block.updated_at'
        ]);
        $staticPageBuilder->where('static_pages_and_block.id', $id);


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
            'type' => [
                'required',
                'int',
                Rule::in([StaticPage::TYPE_BLOCK,StaticPage::TYPE_STATIC_PAGE])
            ],
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
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
            ],
            'description_en' => [
                'nullable',
                'string'
            ],
            'description_bn' => [
                'nullable',
                'string'
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
            'content_type' => [
                'required',
                'int',
                Rule::in([StaticPage::CONTENT_TYPE_IMAGE,StaticPage::CONTENT_TYPE_VIDEO,StaticPage::CONTENT_TYPE_YOUTUBE])
            ],
            'content_path' => [
                'required',
                'string'
            ],
            'content_properties' => [
                'nullable',
                'string'
            ],
            'alt_title_en' => [
                'nullable',
                'string'
            ],
            'alt_title_bn' => [
                'nullable',
                'string'
            ]
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
            'title_en' => 'nullable|max:191|min:2',
            'title_bn' => 'nullable|max:500|min:2',
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
