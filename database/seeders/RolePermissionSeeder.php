<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();

        $allPermissions = Permission::all()->pluck('id')->toArray();
        $editPermissions = Permission::whereIn('name', ['edit_post', 'view_post'])->pluck('id')->toArray();

        if ($adminRole) {
            $adminRole->permissions()->sync($allPermissions);
        }

        if ($editorRole) {
            $editorRole->permissions()->sync($editPermissions);
        }
    }
}
