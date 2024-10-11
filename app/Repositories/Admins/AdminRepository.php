<?php

namespace App\Repositories\Admins;

use App\Repositories\BaseRepository;

class AdminRepository extends BaseRepository implements AdminInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Admin::class;
    }

    public function getEmployee($inputs)
    {
        $employees = $this->model->query();

        if (isset($inputs['name'])) {
            $employees->where(function($query) use ($inputs) {
                $query->where('full_name', 'like', '%' . $inputs['name'] . '%')
                      ->orWhere('email', 'like', '%' . $inputs['name'] . '%')
                      ->orWhere('username', 'like', '%' . $inputs['name'] . '%');
            });
        }

        return $employees->latest()->paginate(20);
    }
}