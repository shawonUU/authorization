<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function assignRoleToUser(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $user->roles()->syncWithoutDetaching($role);
    }

    public function removeRoleFromUser(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        $user->roles()->detach($role);
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function createRole(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create([
                'name' => $data['name'],
            ]);
            if (!empty($data['permissions']) && is_array($data['permissions'])) {
                $role->permissions()->attach($data['permissions']);
            }

            return $role;
        });
    }

    public function updateRole($id, array $data)
    {
        $role = Role::findOrFail($id);

        $role->update([
            'name' => $data['name'],
        ]);

        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        } else {
            $role->permissions()->detach();
        }

        return $role;
    }

    public function deleteRole($id)
    {
        DB::transaction(function () use ($id) {
            $role = Role::findOrFail($id);
            $role->permissions()->detach();
            $role->delete();
        });
    }
}
