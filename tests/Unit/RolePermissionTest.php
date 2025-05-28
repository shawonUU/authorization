<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_can_be_assigned_to_user()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'editor']);

        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole('editor'));
    }

    public function test_permission_can_be_assigned_to_role()
    {
        $role = Role::create(['name' => 'editor']);
        $permission = Permission::create(['name' => 'edit_post']);

        $role->permissions()->attach($permission);

        $this->assertTrue($role->permissions->contains('name', 'edit_post'));
    }

    public function test_user_has_permission_through_role()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'editor']);
        $permission = Permission::create(['name' => 'edit_post']);

        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        $this->assertTrue($user->hasPermission('edit_post'));
    }
}

