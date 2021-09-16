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
        $name = array_key_exists('name', $request) ? $request['name'] : "";
        $order = array_key_exists('order', $request) ? $request['order'] : "ASC";


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
            $menuBuilder->where('menus.title_en', 'like', '%' . $name . '%');
        }
        /** @var Collection $menus */
        $menus = $menuBuilder->get();

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
        $menu = $menuBuilder->first();

        return [
            "data" => $menu ?: [],
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
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'name' => 'nullable|min:1',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ]
        ], $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:191',
            'type' => 'required|max:191'
        ]);
    }

}
