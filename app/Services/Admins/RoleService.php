<?php

namespace App\Services\Admins;

use App\Repositories\Admins\AdminRepository;
use App\Repositories\PermissionRoles\PermissionRoleRepository;
use App\Repositories\Permissions\PermissionRepository;
use App\Repositories\Roles\RoleRepository;
use Illuminate\Support\Facades\DB;

class RoleService
{
    protected $roleRepository;

    protected $adminRepository;

    protected $permissionRepository;

    protected $permissionRoleRepository;

    public function __construct(
        RoleRepository $roleRepository,
        AdminRepository $adminRepository,
        PermissionRepository $permissionRepository,
        PermissionRoleRepository $permissionRoleRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->adminRepository = $adminRepository;
        $this->permissionRepository = $permissionRepository;
        $this->permissionRoleRepository = $permissionRoleRepository;

    }

    public function list()
    {
        return [
            'roles' => $this->roleRepository->getAll()
        ];
    }

    public function delete($id)
    {
        try {
            $role = $this->roleRepository->find($id);
            
            if ($role->admins->count()) {
                return [
                    'success' => 'error',
                    'message' => 'Quyền này đã gán vào tài khoản nên không được phép xóa'
                ];
            }

            return [
                'success' => 'success',
                'message' => 'Xóa thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'error',
                'message' => 'Xóa thất bại'
            ];
        }
    }

    public function store($inputs)
    {
        try {
            DB::beginTransaction();
            $datas = [];
            $role = $this->roleRepository->create($inputs);
            foreach ($inputs['permissions'] as $key => $permissionId) {
                $datas[] = [
                    'role_id' => $role->id,
                    'permission_id' => $permissionId
                ];
            }
            $this->permissionRoleRepository->insert($datas);
            DB::commit();
            
            return [
                'success' => 'success',
                'message' => 'Thêm thành công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();

            return [
                'success' => 'error',
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function addForm()
    {
        return [
            'permissions' => $this->permissionRepository->getAll()->toArray()
        ];
    }

    public function edit($role_id)
    {
        return [
            'role' => $this->roleRepository->find($role_id),
            'permissions' => $this->permissionRepository->getAll()->toArray(),
            'permission_role_olds' => $this->permissionRoleRepository->getPermissionRoleByRole($role_id)->pluck('permission_id')->toArray()
        ];
    }

    public function update($inputs, $role_id)
    {
        try {
            DB::beginTransaction();
            $datas = [];
            $this->permissionRoleRepository->deleteOldRole($role_id);
            $this->roleRepository->update($role_id, [
                'name' => $inputs['name']
            ]);
            foreach ($inputs['permissions'] as $key => $permissionId) {
                $datas[] = [
                    'role_id' => $role_id,
                    'permission_id' => $permissionId
                ];
            }
            $this->permissionRoleRepository->insert($datas);
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sửa thành công'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return [
                'success' => false,
                'message' => 'Vui lòng thử lại'
            ];
        }
    }
}