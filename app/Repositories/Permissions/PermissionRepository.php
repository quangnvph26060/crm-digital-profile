<?php

namespace App\Repositories\Permissions;

use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Permission::class;
    }

    public function list()
    {
        return $this->model->latest()->get();
    }

    public function checkExistPms($code, $idExcept = NULL)
    {
        $pms = $this->model->where('code', $code)
                           ->where(function ($query)  use ($idExcept) {
                                if (!empty($idExcept)) {
                                    $query->where('id', '!=', $idExcept);
                                }
                           })
                           ->first();

        return $pms;
    }
}