<?php

namespace App\Repositories\PermissionRoles;

use App\Repositories\BaseRepository;

class PermissionRoleRepository extends BaseRepository implements PermissionRoleInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\PermissionRole::class;
    }

    public function deleteOldRole($role_id)
    {
        return $this->model->where('role_id', $role_id)->delete();
    }

    public function getPermissionRoleByRole($role_id)
    {
        return $this->model->where('role_id', $role_id)->get();
    }

    public function deletePms($pmsId)
    {
        return $this->model->where('permission_id', $pmsId)->delete();
    }
}
