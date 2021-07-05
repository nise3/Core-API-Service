<?php


namespace App\Services\ServiseInterface;

/*CRUD */

/**
 * Interface BaseServiceInterface
 * @package App\Services\ServiseInterface
 */
interface BaseServiceInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function view($id);

    /**
     * @return mixed
     */
    public function viewAll();

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id);

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id);

    /**
     * @param $data
     * @return mixed
     */
    public function store($data);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);
}
