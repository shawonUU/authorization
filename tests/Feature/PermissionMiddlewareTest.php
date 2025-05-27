<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PermissionMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['web', 'permission:edit_post'])
            ->get('/test-permission', fn () => 'Access granted');
    }

    public function test_user_without_permission_cannot_access_route()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/test-permission');
        $response->assertStatus(403);
    }

    public function test_user_with_permission_can_access_route()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'editor']);
        $permission = Permission::create(['name' => 'edit_post']);
        $role->permissions()->attach($permission);
        $user->roles()->attach($role);

        $response = $this->actingAs($user)->get('/test-permission');
        $response->assertStatus(200);
        $response->assertSee('Access granted');
    }
}
