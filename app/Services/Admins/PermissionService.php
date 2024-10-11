<?php

namespace App\Services\Admins;

use App\Repositories\PermissionRoles\PermissionRoleRepository;
use App\Repositories\Permissions\PermissionRepository;
use Illuminate\Support\Facades\DB;
use Str;

class PermissionService
{
    protected $permissionRepository;

    protected $permissionRoleRepository;

    public function __construct(PermissionRepository $permissionRepository, PermissionRoleRepository $permissionRoleRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->permissionRoleRepository = $permissionRoleRepository;
    }

    public function list()
    {
        return [
            'permissions' => $this->permissionRepository->list()
        ];
    }

    public function store($inputs)
    {
        try {
            $inputs['code'] = Str::slug(trim($inputs['code']));
            $this->permissionRepository->create($inputs);

            return [
                'success' => true,
                'message' => 'Thêm thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function edit($id)
    {
        return [
            'permission' => $this->permissionRepository->find($id)
        ];
    }

    public function update($inputs, $id)
    {
        try {
            $checkExistPermission = $this->permissionRepository->checkExistPms(Str::slug($inputs['code']), $idExcept = $id);

            if (!empty($checkExistPermission)) {
                return [
                    'success' => false,
                    'message' => 'Mã quyền đã tồn tại'
                ];
            }
            $this->permissionRepository->update($id, [
                'name' => $inputs['name'],
                'code' => Str::slug($inputs['code']),
                'description' => $inputs['description']
            ]);
            
            return [
                'success' => true,
                'message' => 'Sửa thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function delete($pmsId)
    {
        try {
            DB::beginTransaction();
            $this->permissionRepository->delete($pmsId);
            $this->permissionRoleRepository->deletePms($pmsId);
            DB::commit();

            return [
                'success' => 'success',
                'message' => 'Xóa thành công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'success' => 'error',
                'message' => 'Vui lòng thử lại'
            ];
        }
    }
}