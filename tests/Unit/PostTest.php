<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_name_email_and_password()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_post_can_be_created()
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Test Post Title',
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, possimus.',
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Post Title', $post->title);
        $this->assertEquals('Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, possimus.', $post->body);
        $this->assertEquals($user->id, $post->user_id);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'user_id' => $user->id,
        ]);
    }

    public function test_post_can_be_updated()
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Old Title',
            'body' => 'Old Body',
            'user_id' => $user->id,
        ]);

        $post->update([
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);

        $this->assertEquals('Updated Title', $post->fresh()->title);
        $this->assertEquals('Updated Body', $post->fresh()->body);
        $this->assertDatabaseHas('posts', [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);
    }

    public function test_post_can_be_deleted()
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Delete Me',
            'body' => 'This post will be deleted',
            'user_id' => $user->id,
        ]);

        $post->delete();

        $this->assertModelMissing($post);
        $this->assertDatabaseMissing('posts', [
            'title' => 'Delete Me',
        ]);
    }
}
