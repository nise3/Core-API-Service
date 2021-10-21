<?php

namespace App\Services\MenuBuilder;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class MenuService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllMenus(array $request, Carbon $startTime): array
    {
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $name = $request['name'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $menuBuilder */
        $menuBuilder = Menu::select([
            'menus.id',
            'menus.name',
            'menus.type',
            'menus.created_at',
            'menus.updated_at',
        ]);
        $menuBuilder->orderBy('menus.id', $order);

        if (!empty($name)) {
            $menuBuilder->where('menus.name', 'like', '%' . $name . '%');
        }
        if (is_numeric($rowStatus)) {
            $menuBuilder->where('menus.row_status', $rowStatus);
        }

        /** @var Collection $menus */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $menus = $menuBuilder->paginate($pageSize);
            $paginateData = (object)$menus->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $menus = $menuBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $menus->toArray()['data'] ?? $menus->toArray();
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
    public function getOneMenu(int $id, Carbon $startTime): array
    {
        /** @var Builder $menuBuilder */
        $menuBuilder = Menu::select([
            'menus.id',
            'menus.name',
            'menus.type',
            'menus.created_at',
            'menus.updated_at',
        ]);
        $menuBuilder->where('menus.id', $id);

        /** @var  $menu */
        $menu = $menuBuilder->firstOrFail();

        return [
            "data" => $menu,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }


    /**
     * @param array $data
     * @return Menu
     */
    public function store(array $data): Menu
    {
        $menu = new Menu();
        $menu->fill($data);
        $menu->save();
        return $menu;
    }

    /**
     * @param Menu $menu
     * @param array $data
     * @return Menu
     */
    public function update(Menu $menu, array $data): Menu
    {
        $menu->fill($data);
        $menu->save();
        return $menu;
    }


    /**
     * @param Menu $menu
     * @return bool
     */
    public function destroy(Menu $menu): bool
    {
        return $menu->delete();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC. [30000]'
        ];

        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        return Validator::make($request->all(), [
            'page' => 'int|gt:0',
            'page_size' => 'int|gt:0',
            'name' => 'nullable|max:191|min:2',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "int",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],

        ], $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:191|min:2',
            'type' => 'required|string|max:191|min:2'
        ]);
    }

}
