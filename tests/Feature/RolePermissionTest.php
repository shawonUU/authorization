<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class RolePermissionTest extends TestCase
{
    public function test_user_with_role_can_access()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'admin']);
        $user->roles()->attach($role);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_user_without_role_cannot_access()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }
}
