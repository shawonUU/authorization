<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionService
{
    public function assignPermissionToRole(string $permissionName, string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $permission = Permission::where('name', $permissionName)->firstOrFail();

        $role->permissions()->syncWithoutDetaching($permission);
    }

    public function removePermissionFromRole(string $permissionName, string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $permission = Permission::where('name', $permissionName)->firstOrFail();

        $role->permissions()->detach($permission);
    }

    public function getPermissions(){
        return Permission::all();
    }

    public function getPermissionById($id)
    {
        return Permission::findOrFail($id);
    }

    public function createPermission(array $data)
    {
        return Permission::create($data);
    }

    public function updatePermission($id, array $data)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($data);
        return $permission;
    }

    public function deletePermission(string $name): void
    {
        $permission = Permission::where('name', $name)->firstOrFail();
        $permission->delete();
    }
}
