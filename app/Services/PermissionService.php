<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionService
{
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

    public function deleteRole($id): void
    {
        $permission = Permission::where('id', $id)->firstOrFail();
        $permission->delete();
    }
}
