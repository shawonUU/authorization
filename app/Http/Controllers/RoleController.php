<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\PermissionService;

class RoleController extends Controller
{
    protected $roleService;
    protected $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('pages.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionService->getPermissions();
        return view('pages.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);
        $this->roleService->createRole($request->all());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function show($id)
    {
        $role = $this->roleService->getRoleById($id);
        return view('roles.show', compact('role'));
    }

    public function edit($id)
    {
        $role = $this->roleService->getRoleById($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $id,
        ]);

        $this->roleService->updateRole($id, $request->all());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
