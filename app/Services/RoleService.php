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
            // Create the role
            $role = Role::create([
                'name' => $data['name'],
            ]);

            // Attach permissions if provided
            if (!empty($data['permissions']) && is_array($data['permissions'])) {
                $role->permissions()->attach($data['permissions']);
            }

            return $role;
        });
    }

    public function updateRole($id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        return $role->delete();
    }
}
