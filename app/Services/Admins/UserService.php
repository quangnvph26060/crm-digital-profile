<?php

namespace App\Services\Admins;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Admins\AdminRepository;
use App\Repositories\Roles\RoleRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;

    protected $roleRepository;

    protected $adminRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        AdminRepository $adminRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->adminRepository = $adminRepository;
    }

    public function listUser($inputs)
    {
        try {
            $employees = $this->userRepository->getUser($inputs);
            
            return [
                'success' => true,
                'inputs' => $inputs,
                'employees' => $employees
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false
            ];
        }
    }

    public function listEmployee($inputs)
    {
        try {
            $employees = $this->adminRepository->getEmployee($inputs);
            
            return [
                'success' => true,
                'inputs' => $inputs,
                'employees' => $employees
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false
            ];
        }
    }

    public function changeStatus($inputs)
    {
        try {
            $this->userRepository->update($inputs['user_id'], ['status' => $inputs['status']]);

            return [
                'success' => 'success',
                'message' => 'Cập nhật thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'error',
                'message' => 'Cập nhật thành công'
            ];
        }
    }

    public function changeStatusEmployee($inputs)
    {
        try {
            $this->adminRepository->update($inputs['user_id'], ['status' => $inputs['status']]);

            return [
                'success' => 'success',
                'message' => 'Cập nhật thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'error',
                'message' => 'Cập nhật thành công'
            ];
        }
    }

    public function addEmployeeForm()
    {
        $roles = $this->roleRepository->getAll();

        return [
            'roles' => $roles
        ];
    }

    public function storeUser($inputs)
    {
        try {
            $user = NULL;
            $parent_id = 0;

            if (!empty($inputs['ref_code'])) {
                $user = $this->userRepository->findUserByRefCode($inputs['ref_code']);

                if (empty($user)) {
                    return [
                        'success' => 'error',
                        'message' => 'Mã giới thiệu không tồn tại'
                    ];
                }
                $parent_id = empty($user) ? 0 : $user->id;
            }
            DB::beginTransaction();
            $this->userRepository->create([
                'full_name' => $inputs['full_name'],
                'ref_code' => 'SV_' . substr(rand(), rand(0, 3), 8),
                'type' => $inputs['type'],
                'shop_name' => $inputs['shop_name'],
                'email' => $inputs['email'],
                'phone' => $inputs['phone'],
                'parent_id' => $parent_id,
                'status' => User::ACTIVE,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt($inputs['password'])
            ]);
            /**
             * Nếu có mã giới thiệu mà user giới thiệu k phải admin thì cập nhật user đó là đại lý do đã giới thiệu được shop
             */
            if ($parent_id > 0 && $user->role_code != Role::ROLE_ADMIN) {
                $this->userRepository->update($user->id, ['ref_code' => Role::ROLE_AGENCY]);
            }
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

    public function storeEmployee($inputs)
    {
        try {
            $inputs['password'] = bcrypt($inputs['password']);
            $this->adminRepository->create($inputs);

            return [
                'success' => 'success',
                'message' => 'Thêm nhân viên thành công'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'error',
                'message' => 'Vui lòng thử lại'
            ];
        }
    }

    public function editEmployeeForm($admin_id)
    {
        return [
            'employee' => $this->adminRepository->find($admin_id),
            'roles' => $this->roleRepository->getAll()
        ];
    }

    public function updateEmployee($inputs, $admin_id)
    {
        try {
            $employee = $this->adminRepository->find($admin_id);
            $employee->update([
                'full_name' => $inputs['full_name'],
                'role_code' => $inputs['role_code'],
                'password' => !empty($inputs['password']) ? bcrypt($inputs['password']) : $employee->password
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
}
