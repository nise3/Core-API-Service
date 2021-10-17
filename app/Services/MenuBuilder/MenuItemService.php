<?php

namespace App\Services\MenuBuilder;

use App\Models\BaseModel;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


class MenuItemService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllMenuItems(array $request, Carbon $startTime): array
    {
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";


        /** @var Builder $menuItemBuilder */
        $menuItemBuilder = MenuItem::select([
            'menu_items.id',
            'menu_items.menu_id',
            'menu_items.title',
            'menu_items.title_lang_key',
            'menu_items.permission_key',
            'menu_items.url',
            'menu_items.target',
            'menu_items.icon_class',
            'menu_items.color',
            'menu_items.parent_id',
            'menu_items.order',
            'menu_items.route',
            'menu_items.parameters',
            'menu_items.created_at',
            'menu_items.updated_at',
        ]);

        $menuItemBuilder->leftJoin('menus', function ($join) use ($rowStatus) {
            $join->on('menu_items.menu_id', '=', 'menus.id');
            if (is_int($rowStatus)) {
                $join->where('menus.row_status', $rowStatus);
            }
        });
        $menuItemBuilder->leftJoin('menu_items as parent', function ($join) use ($rowStatus) {
            $join->on('menu_items.parent_id', '=', 'parent.id');
            if (is_int($rowStatus)) {
                $join->where('permission_groups.row_status', $rowStatus);
            }
        });
        $menuItemBuilder->orderBy('menu_items.id', $order);
        if (!empty($title)) {
            $menuItemBuilder->where('menu_items.title', 'like', '%' . $title . '%');
        }
        if (is_int($rowStatus)) {
            $menuItemBuilder->where('menus.row_status', $rowStatus);
        }
        /** @var Collection $menuItems */


        /** @var Collection $menuItems */
        if (is_int($paginate) || is_int($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $menuItems = $menuItemBuilder->paginate($pageSize);
            $paginateData = (object)$menuItems->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $menuItems = $menuItemBuilder->get();
        }


        $response['order'] = $order;
        $response['data'] = $menuItems->toArray()['data'] ?? $menuItems->toArray();
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
    public function getOneMenuItem(int $id, Carbon $startTime): array
    {

        /** @var Builder $menuItemBuilder */
        $menuItemBuilder = MenuItem::select([
            'menu_items.id',
            'menu_items.menu_id',
            'menus.name as menu_name',
            'menus.type as menu_type',
            'menu_items.title',
            'menu_items.title_lang_key',
            'menu_items.permission_key',
            'menu_items.url',
            'menu_items.target',
            'menu_items.icon_class',
            'menu_items.color',
            'menu_items.parent_id',
            'parent.title as parent_title',
            'menu_items.order',
            'menu_items.route',
            'menu_items.parameters',
            'menu_items.created_at',
            'menu_items.updated_at',
        ]);

        $menuItemBuilder->leftJoin('menus', function ($join) {
            $join->on('menu_items.menu_id', '=', 'menus.id');
        });
        $menuItemBuilder->leftJoin('menu_items as parent', function ($join) {
            $join->on('menu_items.parent_id', '=', 'parent.id');
        });
        $menuItemBuilder->where('menu_items.id', $id);

        /** @var  MenuItem $menuItem */
        $menuItem = $menuItemBuilder->first();

        return [
            "data" => $menuItem ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now())
            ],
        ];
    }

    /**
     * @param array $data
     * @return MenuItem
     */
    public function store(array $data): MenuItem
    {
        $menuItem = new MenuItem();
        $menuItem->fill($data);
        $menuItem->save();
        return $menuItem;
    }

    /**
     * @param MenuItem $menuItem
     * @param array $data
     * @return MenuItem
     */
    public function update(MenuItem $menuItem, array $data): MenuItem
    {
        $menuItem->fill($data);
        $menuItem->save();
        return $menuItem;
    }


    /**
     * @param MenuItem $menuItem
     * @return bool
     */
    public function destroy(MenuItem $menuItem): bool
    {
        return $menuItem->delete();
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
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'page' => 'int|gt:0',
            'page_size' => 'int|gt:0',
            'title' => 'nullable|max:191|min:2',
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
    public function Validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'menu_id' => 'nullable|exists:menus,id|int',
            'title' => 'required_without:title_lang_key|max:191|min:2',
            'title_lang_key' => 'required_without:title|max:255|min:2',
            'permission_key' => 'nullable|string|max:191',
            'url' => 'required_without:route|string|max:191',
            'target' => 'nullable|string|max:191',
            'icon_class' => 'required|string|max:191',
            'color' => 'nullable|string|max:191',
            'parent_id' => 'nullable|exists:menu_items,id|int',
            'order' => 'int' | 'required',
            'route' => 'required_without:url|string|max:191',
            'parameters' => 'nullable|string'
        ];

        return Validator::make($request->all(), $rules);
    }

}
