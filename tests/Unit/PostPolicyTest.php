<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use PHPUnit\Framework\TestCase;

class PostPolicyTest extends TestCase
{
    protected PostPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PostPolicy();
    }

    public function test_viewAny_allows_admin_or_with_permission()
    {
        $user = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $user->expects($this->once())->method('hasRole')->with('admin')->willReturn(true);
        $user->expects($this->never())->method('hasPermission');
        $this->assertTrue($this->policy->viewAny($user));

        $user = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $user->expects($this->once())->method('hasRole')->with('admin')->willReturn(false);
        $user->expects($this->once())->method('hasPermission')->with('view_post')->willReturn(true);
        $this->assertTrue($this->policy->viewAny($user));

        $user = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $user->expects($this->once())->method('hasRole')->with('admin')->willReturn(false);
        $user->expects($this->once())->method('hasPermission')->with('view_post')->willReturn(false);
        $this->assertFalse($this->policy->viewAny($user));
    }

    public function test_view_allows_if_user_owns_post()
    {
        $user = new User();
        $user->id = 1;

        $post = new Post();
        $post->user_id = 1;

        $this->assertTrue($this->policy->view($user, $post));

        $post->user_id = 2;
        $this->assertFalse($this->policy->view($user, $post));
    }

    public function test_create_allows_admin_or_with_permission()
    {
        $user = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $user->expects($this->once())->method('hasRole')->with('admin')->willReturn(true);
        $user->expects($this->never())->method('hasPermission');

        $this->assertTrue($this->policy->create($user));

        $user = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $user->expects($this->once())->method('hasRole')->with('admin')->willReturn(false);
        $user->expects($this->once())->method('hasPermission')->with('create_post')->willReturn(true);

        $this->assertTrue($this->policy->create($user));

        $user = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $user->expects($this->once())->method('hasRole')->with('admin')->willReturn(false);
        $user->expects($this->once())->method('hasPermission')->with('create_post')->willReturn(false);

        $this->assertFalse($this->policy->create($user));
    }

    public function test_update_allows_owner_or_with_permission()
    {
        $post = new Post();
        $post->user_id = 1;

        $ownerUser = $this->getMockBuilder(User::class)->onlyMethods(['hasPermission'])->getMock();
        $ownerUser->id = 1;
        $ownerUser->expects($this->never())->method('hasPermission');

        $this->assertTrue($this->policy->update($ownerUser, $post));

        $permittedUser = $this->getMockBuilder(User::class)->onlyMethods(['hasPermission'])->getMock();
        $permittedUser->id = 2;
        $permittedUser->expects($this->once())->method('hasPermission')->with('edit_post')->willReturn(true);

        $this->assertTrue($this->policy->update($permittedUser, $post));

        $unauthorizedUser = $this->getMockBuilder(User::class)->onlyMethods(['hasPermission'])->getMock();
        $unauthorizedUser->id = 3;
        $unauthorizedUser->expects($this->once())->method('hasPermission')->with('edit_post')->willReturn(false);

        $this->assertFalse($this->policy->update($unauthorizedUser, $post));
    }

    public function test_delete_allows_admin_or_with_permission()
    {
        $post = new Post();

        $adminUser = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $adminUser->expects($this->once())->method('hasRole')->with('admin')->willReturn(true);
        $adminUser->expects($this->never())->method('hasPermission');

        $this->assertTrue($this->policy->delete($adminUser, $post));

        $permittedUser = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $permittedUser->expects($this->once())->method('hasRole')->with('admin')->willReturn(false);
        $permittedUser->expects($this->once())->method('hasPermission')->with('delete_post')->willReturn(true);

        $this->assertTrue($this->policy->delete($permittedUser, $post));

        $unauthorizedUser = $this->getMockBuilder(User::class)->onlyMethods(['hasRole', 'hasPermission'])->getMock();
        $unauthorizedUser->expects($this->once())->method('hasRole')->with('admin')->willReturn(false);
        $unauthorizedUser->expects($this->once())->method('hasPermission')->with('delete_post')->willReturn(false);

        $this->assertFalse($this->policy->delete($unauthorizedUser, $post));
    }

    public function test_restore_always_returns_false()
    {
        $user = new User();
        $post = new Post();

        $this->assertFalse($this->policy->restore($user, $post));
    }

    public function test_forceDelete_always_returns_false()
    {
        $user = new User();
        $post = new Post();

        $this->assertFalse($this->policy->forceDelete($user, $post));
    }
}
