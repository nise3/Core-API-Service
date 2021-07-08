<?php


namespace App\Services\LocationManagementServices;


use App\Models\LocDivision;
use App\Services\ServiseInterface\BaseServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\ErrorException;
use Ramsey\Uuid\Type\Integer;


/**
 * Class LocService
 * @package App\Services\Sevices
 */
class LocDivisionService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getAllDivisions(Request $request)
    {
        $paginate_link = [];
        $page = [];
        $startTime = Carbon::now();

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
            $_links['view'] = route('api.v1.divisions.view', ['id' => $division->id]);
            $_links['edit'] = route('api.v1.divisions.view', ['id' => $division->id]);
            $_links['delete'] = route('api.v1.divisions.destroy', ['id' => $division->id]);
            $division['_links'] = $_links;
            $data[] = $division->toArray();

        }
        $response = [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
                'search' => [
                    'parameters' => [
                        'title_en',
                        'title_bn'
                    ],
                    '_link' => route('api.v1.divisions.view-all')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];
        return $response;
    }

    /**
     * @param $id
     * @return array
     */
    public function getOneDivision($id)
    {
        $startTime = Carbon::now();
        $links = [];

        $division = LocDivision::select([
            'id',
            'title_bn',
            'title_en',
            'bbs_code'
        ])->where([
            'id' => $id,
            'row_status' => 1
        ])->first();
        if (!empty($division)) {
            $links = [
                'edit' => route('api.v1.divisions.view', ['id' => $division->id]),
                'delete' => route('api.v1.divisions.destroy', ['id' => $division->id])
            ];
        }
        $response = [
            "data" => $division ? $division : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
        return $response;
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        LocDivision::create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $update = LocDivision::find($id);
        $update->fill($request->all());
        $update->save();
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $delete = LocDivision::find($id);
        $delete->row_status = 99;
        $delete->save();
    }

}
