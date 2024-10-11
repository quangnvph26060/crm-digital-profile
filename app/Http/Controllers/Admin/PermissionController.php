<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\CreatePermissionRequest;
use App\Http\Requests\Admin\Permissions\EditPermissionRequest;
use App\Services\Admins\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function list()
    {
        return view('admins.pages.permissions.list', $this->permissionService->list());
    }

    public function create()
    {
        return view('admins.pages.permissions.add');
    }

    public function store(CreatePermissionRequest $request)
    {
        $result = $this->permissionService->store($request->except('_token'));

        if ($result['success']) {
            return redirect()->route('admin.permission.list');
        }

        return back()->with('error', $result['message']);
    }

    public function edit($pmsId)
    {
        return view('admins.pages.permissions.edit', $this->permissionService->edit($pmsId));
    }

    public function update(EditPermissionRequest $request, $pmsId)
    {
        $result = $this->permissionService->update($request->except('_token'), $pmsId);

        if ($result['success']) {
            return redirect()->route('admin.permission.list')->with('success', 'Sửa thành công');
        }

        return back()->withInput()->with('error', $result['message']);
    }

    public function delete($pmsId)
    {
        $result = $this->permissionService->delete($pmsId);

        return back()->with($result['success'], $result['message']);
    }
}

