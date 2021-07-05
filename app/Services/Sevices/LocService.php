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
        $this->model=$model;
    }

    public function view($id)
    {
       return $this->model->find($id);
    }

    public function viewAll()
    {
        return $this->model->where('status',1)
            ->orderBy('id','ASC')
            ->paginate(2)
            ->toArray();

    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function update($data, $id)
    {
      $update= $this->model->find($id);
      $update->fill($data->all());
      $update->save();
    }

    public function store($data)
    {
        $this->model->create($data->all());
    }

    public function destroy($id)
    {
        $delete= $this->model->find($id);
        $delete->status=99;
        $delete->save();
    }

}
