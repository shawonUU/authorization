<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_roles()
    {
        $user = User::factory()->create();
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'editor']);

        $user->roles()->attach([$role1->id, $role2->id]);

        $this->assertCount(2, $user->roles);
    }

    public function test_role_has_many_permissions()
    {
        $role = Role::create(['name' => 'editor']);
        $p1 = Permission::create(['name' => 'edit_post']);
        $p2 = Permission::create(['name' => 'delete_post']);

        $role->permissions()->attach([$p1->id, $p2->id]);

        $this->assertCount(2, $role->permissions);
    }
}
