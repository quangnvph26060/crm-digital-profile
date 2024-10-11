<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use DB;

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn tương tác
    protected $model;

   //khởi tạo
    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->latest('id')->get();
    }

    public function getAllActive()
    {
        return $this->model->latest('id')->where('status', ACTIVE)->get();
    }

    public function getPaginate($limit, $latest)
    {
        return $this->model->latest($latest)->paginate($limit);
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function insert($attributes = [])
    {
        return $this->model->insert($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);

        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function findSlug($slug)
    {
        $result = $this->model->where('slug', $slug)
                              ->first();

        return $result;
    }

    public function totalRow()
    {
        return $this->model->select('id')->count();
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function updateOrCreate($arrayCheck, $arrayInsert)
    {
        return $this->model->updateOrCreate($arrayCheck, $arrayInsert);
    }
}
