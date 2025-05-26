<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

     public function __construct( PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->getPermissions();
        return view('pages.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('pages.permission.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name',
        ]);
        $this->permissionService->createPermission($request->all());
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = $this->permissionService->getPermissionById($id);
        return view('pages.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name,' . $id,
        ]);

        $this->permissionService->updatePermission($id, $request->all());
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
