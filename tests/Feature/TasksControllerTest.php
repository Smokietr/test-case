<?php

namespace Tests\Feature;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        \DB::statement('PRAGMA foreign_keys=ON;');
    }

    private array $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    public function test_store_creates_a_task()
    {
        $user = User::factory()->create();

        $taskData = [
            'name' => 'Test Task',
            'description' => 'Test Description',
            'user_id' => $user->id,
            'status' => 'pending'
        ];

        $response = $this->actingAs($user)
            ->withHeaders($this->headers)
            ->postJson('/api/tasks', $taskData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Task']);
    }

    public function test_update_changes_task_status()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('password')
        ]);

        $task = Tasks::factory()->create(['status' => 'pending', 'user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->withHeaders($this->headers)
            ->putJson("/api/tasks/{$task->id}", ['status' => 'completed']);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'completed']);
    }

    public function test_destroy_deletes_task()
    {
        $user = User::factory()->create();
        $task = Tasks::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->withHeaders($this->headers)
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
