<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/tasks', [
                'title' => 'Test Task',
                'description' => 'This is a test task'
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message', 'task']);
    }

    public function test_user_cannot_create_task_without_title()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/tasks', [
                'description' => 'No title here'
            ]);

        $response->assertStatus(422);
    }

}