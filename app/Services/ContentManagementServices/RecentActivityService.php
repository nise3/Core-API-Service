<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\RecentActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RecentActivityService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getRecentActivityList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";


        /** @var  Builder $recentActivityBuilder */
        $recentActivityBuilder = RecentActivity::select([
            'recent_activities.id',
            'recent_activities.title_en',
            'recent_activities.title_bn',
            'recent_activities.institute_id',
            'recent_activities.organization_id',
            'recent_activities.description_en',
            'recent_activities.description_bn',
            'recent_activities.content_type',
            'recent_activities.content_path',
            'recent_activities.content_properties',
            'recent_activities.alt_title_en',
            'recent_activities.alt_title_bn',
            'recent_activities.publish_date',
            'recent_activities.archive_date',
            'recent_activities.created_by',
            'recent_activities.updated_by',
            'recent_activities.created_at',
            'recent_activities.updated_at',
        ]);
        $recentActivityBuilder->orderBy('recent_activities.id', $order);

        if (is_numeric($rowStatus)) {
            $recentActivityBuilder->where('recent_activities.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $recentActivityBuilder->where('recent_activities.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $recentActivityBuilder->where('recent_activities.title_bn', 'like', '%' . $titleBn . '%');
        }


        /** @var Collection $recentActivity */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $recentActivity = $recentActivityBuilder->paginate($pageSize);
            $paginateData = (object)$recentActivity->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $recentActivity = $recentActivityBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $recentActivity->toArray()['data'] ?? $recentActivity->toArray();
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
    public function getOneRecentActivity(int $id, Carbon $startTime): array
    {
        /** @var  Builder $recentActivityBuilder */
        $recentActivityBuilder = RecentActivity::select([
            'recent_activities.id',
            'recent_activities.title_en',
            'recent_activities.title_bn',
            'recent_activities.institute_id',
            'recent_activities.organization_id',
            'recent_activities.description_en',
            'recent_activities.description_bn',
            'recent_activities.content_type',
            'recent_activities.content_path',
            'recent_activities.content_properties',
            'recent_activities.alt_title_en',
            'recent_activities.alt_title_bn',
            'recent_activities.publish_date',
            'recent_activities.archive_date',
            'recent_activities.created_by',
            'recent_activities.updated_by',
            'recent_activities.created_at',
            'recent_activities.updated_at',
        ]);
        $recentActivityBuilder->where('recent_activities.id', $id);

        /** @var Collection $noticeOrNews */
        $recentActivity = $recentActivityBuilder->first();

        return [
            "data" => $recentActivity ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }

    /**
     * @param array $data
     * @return RecentActivity
     */
    public function store(array $data): RecentActivity
    {
        $recentActivity = new RecentActivity();
        $recentActivity->fill($data);
        $recentActivity->save();
        return $recentActivity;
    }


    /**
     * @param RecentActivity $recentActivity
     * @param array $data
     * @return RecentActivity
     */
    public function update(RecentActivity $recentActivity, array $data): RecentActivity
    {

        $recentActivity->fill($data);
        $recentActivity->save();
        return $recentActivity;
    }


    /**
     * @param RecentActivity $recentActivity
     * @return bool
     */
    public function destroy(RecentActivity $recentActivity): bool
    {
        return $recentActivity->delete();
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
        $rules = [
            "title_en" => "nullable",
            "title_bn" => "nullable",
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'Content_type' => [
                'nullable',
                Rule::in([RecentActivity::CONTENT_TYPE_IMAGE, RecentActivity::CONTENT_TYPE_VIDEO . RecentActivity::CONTENT_TYPE_YOUTUBE])
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
            'content_path' => [
                'nullable',
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
            ],
            'publish_date' => [
                'nullable',
                'date',
                'date_format:Y-m-d',
                'before:archive_date'
            ],
            'archive_date' => [
                'nullable',
                'date',
                'date_format:Y-m-d',
                'after:publish_date'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]

        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

}
