<?php

namespace App\Repositories\Roles;

use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Role::class;
    }

    public function findRoleByCode($code)
    {
        return $this->model->where('code', $code)->first();
    }

    public function getRoleExcept($except)
    {
        return $this->model->where('code', '!=', $except)->get();
    }
}
