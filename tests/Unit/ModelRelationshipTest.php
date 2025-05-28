<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_multiple_roles()
    {
        $user = User::factory()->create();
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleEditor = Role::create(['name' => 'editor']);

        $user->roles()->attach([$roleAdmin->id, $roleEditor->id]);

        $user->refresh();

        $this->assertCount(2, $user->roles);
        $this->assertTrue($user->roles->contains('name', 'admin'));
        $this->assertTrue($user->roles->contains('name', 'editor'));

        $roleAdmin->load('users');
        $this->assertTrue($roleAdmin->users->contains($user));
    }

    public function test_role_can_have_multiple_permissions()
    {
        $role = Role::create(['name' => 'editor']);
        $permEdit = Permission::create(['name' => 'edit_post']);
        $permDelete = Permission::create(['name' => 'delete_post']);

        $role->permissions()->attach([$permEdit->id, $permDelete->id]);

        $role->refresh();

        $this->assertCount(2, $role->permissions);
        $this->assertTrue($role->permissions->contains('name', 'edit_post'));
        $this->assertTrue($role->permissions->contains('name', 'delete_post'));

        $permEdit->load('roles');
        $this->assertTrue($permEdit->roles->contains($role));
    }

    public function test_user_roles_are_persisted_in_database()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'admin']);
        $user->roles()->attach($role->id);

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }

    public function test_role_permissions_are_persisted_in_database()
    {
        $role = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'manage_users']);
        $role->permissions()->attach($permission->id);

        $this->assertDatabaseHas('permission_role', [
            'role_id' => $role->id,
            'permission_id' => $permission->id,
        ]);
    }
}
