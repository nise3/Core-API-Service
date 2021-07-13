<?php


namespace App\Services\LocationManagementServices;


use App\Models\LocDistrict;
use App\Models\LocDivision;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;


/**
 * Class LocService
 * @package App\Services\Sevices
 */
class LocDivisionService
{
    public Carbon $startTime;
    const ROUTE_PREFIX = 'api.v1.divisions.';

    /**
     * LocDivisionService constructor.
     * @param Carbon $startTime
     */
    public function __construct(Carbon $startTime)
    {
        $this->startTime = $startTime;
    }


    /**
     * @param Request $request
     * @return array
     */
    public function getAllDivisions(Request $request): array
    {
        $paginate_link = [];
        $page = [];


        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var LocDivision|Builder $divisions */
        $divisions = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code',
        ]);
        $divisions->orderBy('id', $order);
        $divisions->where('row_status', LocDivision::ROW_STATUS_ACTIVE);

        if (!empty($request->query('title_en'))) {
            $divisions->where('title_en', 'like', '%' . $request->query('title_en') . '%');
        } elseif (!empty($request->query('title_bn'))) {
            $divisions->where('title_bn', 'like', '%' . $request->query('title_bn') . '%');
        }
        if ($paginate) {
            $divisions = $divisions->paginate(10);
            $paginate_data = (object)$divisions->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $divisions = $divisions->get();
        }

        $data = [];
        foreach ($divisions as $division) {
            $_links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $division->id]);
            $_links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $division->id]);
            $_links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $division->id]);
            $division['_links'] = $_links;
            $data[] = $division->toArray();

        }
        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
                'search' => [
                    'parameters' => [
                        'title_en',
                        'title_bn'
                    ],
                    '_link' => route(self::ROUTE_PREFIX . 'get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function getOneDivision($id): array
    {

        $links = [];

        $division = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code'
        ])->where([
            'id' => $id,
            'row_status' => LocDivision::ROW_STATUS_ACTIVE
        ])->first();

        if (!empty($division)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $division->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $division->id])
            ];
        }

        return [
            "data" => $division ? $division : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
    }

    /**
     * @param array $data
     * @return LocDivision
     */
    public function store(array $data): LocDivision
    {
        return LocDivision::create($data);
    }


    /**
     * @param array $data
     * @param LocDivision $locDivision
     * @return bool
     */
    public function update(array $data, LocDivision $locDivision): LocDivision
    {
        $locDivision->fill($data);
        $locDivision->save();
        return $locDivision;
    }

    /**
     * @param LocDivision $locDivision
     * @return bool
     */
    public function destroy(LocDivision $locDivision): LocDivision
    {
        $locDivision->row_status = LocDivision::ROW_STATUS_DELETED;
        $locDivision->save();
        return $locDivision;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'title_en' => 'required|min:2',
            'title_bn' => 'required|min:2',
        ]);
    }

}
