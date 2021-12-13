<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function createUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make($this->faker->password(8)),
        ];

        return User::create($userData);
    }

    public function test_show_post_unauthorized()
    {
        $response = $this->getJson('/api/posts/1');

        $response->assertStatus(401);
    }

    public function test_show_post_not_found()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;

        $response = $this->actingAs($user)->getJson('/api/posts/1');

        $response->assertStatus(404);
    }

    public function test_show_post_forbidden()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;

        $post = Post::create([
            'user_id' => 9,
            'title' => $this->faker->title,
            'body' => $this->faker->text
        ]);

        $response = $this->actingAs($user)->getJson('/api/posts/1');

        $response->assertStatus(403);
    }

    public function test_show_post_success()
    {
        $user = $this->createUser();
        $token = $user->createToken('ios')->plainTextToken;

        $post = Post::create([
            'user_id' => 1,
            'title' => $this->faker->title,
            'body' => $this->faker->text
        ]);

        $response = $this->actingAs($user)->getJson('/api/posts/1');

        $response->assertStatus(200);
    }
}
