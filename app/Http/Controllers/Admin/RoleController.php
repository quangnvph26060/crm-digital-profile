<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\Roles\EditRoleRequest;
use App\Services\Admins\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    
    public function list()
    {
        return view('admins.pages.roles.list', $this->roleService->list());
    }

    public function delete($id)
    {
        $result = $this->roleService->delete($id);

        return back()->with($result['success'], $result['message']);
    }

    public function addForm()
    {
        return view('admins.pages.roles.add', $this->roleService->addForm());
    }

    public function store(CreateRoleRequest $request)
    {
        $result = $this->roleService->store($request->except('_token'));

        return redirect()->route('admin.role.list')->with($result['success'], $result['message']);
    }

    public function edit($id)
    {
        return view('admins.pages.roles.edit', $this->roleService->edit($id));
    }

    public function update(EditRoleRequest $request, $role_id)
    {
        $result = $this->roleService->update($request->except('_token'), $role_id);

        if ($result['success']) {
            return redirect()->route('admin.role.list')->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
