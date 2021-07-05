<?php


namespace App\Services\Sevices;


use App\Services\ServiseInterface\BaseServiceInterface;

/**
 * Class LocService
 * @package App\Services\Sevices
 */
class LocService implements BaseServiceInterface
{

    /**
     * @var
     */
    public $model;

    /**
     * LocService constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function view($id, $relation = null)
    {
        $response = $this->model->where(
            [
                'row_status' => 1,
                'id' => $id

            ]);
        if (!empty($relation)) {
            $response->with($relation);
        }
        $response = $response->first();

        return $response;

    }

    public function viewAll($relation = null)
    {
        $response = $this->model->where('row_status', 1)
            ->orderBy('id', 'ASC');
        if (!empty($relation)) {
            $response->with($relation);
        }
        $response = $response->paginate(2);
        return $response;
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function update($data, $id)
    {
        $update = $this->model->find($id);
        $update->fill($data->all());
        $update->save();
    }

    public function store($data)
    {
        $this->model->create($data->all());
    }

    public function destroy($id)
    {
        $delete = $this->model->find($id);
        $delete->row_status = 99;
        $delete->save();
    }

    public function getDistrictByDivisionId($division_id)
    {
        return $this->model->where(
            [
                'row_status' => 1,
                'loc_division_id' => $division_id
            ])->get();
    }
    public function getUpazilaByDistrictId($district_id)
    {
        return $this->model->where(
            [
                'row_status' => 1,
                'loc_district_id' => $district_id
            ])->get();
    }

}
