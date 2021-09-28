<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\NoticeOrNews;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class NoticeOrNewsService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getNoticeOrNewsServiceList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title_bn'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $noticeOrNewsBuilder */
        $noticeOrNewsBuilder = NoticeOrNews::select([
            'notice_or_news.id',
            'notice_or_news.type',
            'notice_or_news.title_en',
            'notice_or_news.title_bn',
            'notice_or_news.institute_id',
            'notice_or_news.organization_id',
            'notice_or_news.description_en',
            'notice_or_news.description_bn',
            'notice_or_news.image',
            'notice_or_news.file',
            'notice_or_news.image_alt_title_en',
            'notice_or_news.image_alt_title_bn',
            'notice_or_news.file_alt_title_en',
            'notice_or_news.file_alt_title_bn',
            'notice_or_news.row_status',
            'notice_or_news.publish_date',
            'notice_or_news.archive_date',
            'notice_or_news.created_by',
            'notice_or_news.updated_by',
            'notice_or_news.created_at',
            'notice_or_news.created_at',
        ]);
        $noticeOrNewsBuilder->orderBy('notice_or_news.id', $order);

        if (is_numeric($rowStatus)) {
            $noticeOrNewsBuilder->where('notice_or_news.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $noticeOrNewsBuilder->where('notice_or_news.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $noticeOrNewsBuilder->where('notice_or_news.title_bn', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $noticeOrNews */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $noticeOrNews = $noticeOrNewsBuilder->paginate($pageSize);
            $paginateData = (object)$noticeOrNews->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $noticeOrNews = $noticeOrNewsBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $noticeOrNews->toArray()['data'] ?? $noticeOrNews->toArray();
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
    public function getOneNoticeOrNewsService(int $id, Carbon $startTime): array
    {
        /** @var Builder $noticeOrNewsBuilder */
        $noticeOrNewsBuilder = NoticeOrNews::select([
            'notice_or_news.id',
            'notice_or_news.type',
            'notice_or_news.title_en',
            'notice_or_news.title_bn',
            'notice_or_news.institute_id',
            'notice_or_news.organization_id',
            'notice_or_news.description_en',
            'notice_or_news.description_bn',
            'notice_or_news.image',
            'notice_or_news.file',
            'notice_or_news.image_alt_title_en',
            'notice_or_news.image_alt_title_bn',
            'notice_or_news.file_alt_title_en',
            'notice_or_news.file_alt_title_bn',
            'notice_or_news.row_status',
            'notice_or_news.publish_date',
            'notice_or_news.archive_date',
            'notice_or_news.created_by',
            'notice_or_news.updated_by',
            'notice_or_news.created_at',
            'notice_or_news.created_at',
        ]);
        $noticeOrNewsBuilder->where('notice_or_news.id', $id);

        /** @var Collection $noticeOrNews */
        $noticeOrNews = $noticeOrNewsBuilder->first();

        return [
            "data" => $noticeOrNews ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }


    /**
     * @param array $data
     * @return NoticeOrNews
     */
    public function store(array $data): NoticeOrNews
    {
        $noticeOrNews = new NoticeOrNews();
        $noticeOrNews->fill($data);
        $noticeOrNews->save();
        return $noticeOrNews;
    }


    /**
     * @param NoticeOrNews $noticeOrNews
     * @param array $data
     * @return NoticeOrNews
     */
    public function update(NoticeOrNews $noticeOrNews, array $data): NoticeOrNews
    {

        $noticeOrNews->fill($data);
        $noticeOrNews->save();
        return $noticeOrNews;
    }


    /**
     * @param NoticeOrNews $noticeOrNews
     * @return bool
     */
    public function destroy(NoticeOrNews $noticeOrNews): bool
    {
        return $noticeOrNews->delete();
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
            'type' => [
                'required',
                Rule::in([NoticeOrNews::TYPE_NOTICE, NoticeOrNews::TYPE_NEWS])
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
            'image' => [
                'nullable',
                'string'
            ],
            'file' => [
                'nullable',
                'string'
            ],
            'image_alt_title_en' => [
                'nullable',
                'string'
            ],
            'image_alt_title_bn' => [
                'nullable',
                'string'
            ],
            'file_alt_title_en' => [
                'nullable',
                'string'
            ],
            'file_alt_title_bn' => [
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
