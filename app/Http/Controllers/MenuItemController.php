<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Services\MenuBuilder\MenuItemService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;


class MenuItemController extends Controller
{

    public MenuItemService $menuItemService;


    private Carbon $startTime;


    public function __construct(MenuItemService $menuItemService)
    {
        $this->startTime = Carbon::now();
        $this->menuItemService = $menuItemService;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->menuItemService->filterValidator($request)->validate();
        try {
            $response = $this->menuItemService->getAllMenuItems($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function read(int $id): JsonResponse
    {
        try {
            $response = $this->menuItemService->getOneMenuItem($id, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->menuItemService->validator($request)->validate();
        try {
            $menuItem = $this->menuItemService->store($validated);
            $response = [
                'data' => $menuItem,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "MenuItem added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $menuItem = MenuItem::findOrFail($id);
        $validated = $this->menuItemService->validator($request, $id)->validate();
        try {
            $menuItem = $this->menuItemService->update($menuItem, $validated);
            $response = [
                'data' => $menuItem,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "MenuItem updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $menuItem = MenuItem::findOrFail($id);
        try {
            $this->menuItemService->destroy($menuItem);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "MenuItem deleted successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
                ]
            ];
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
