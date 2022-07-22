<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /**
     *
     * @return void
     */

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        TaskStatus::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testShow()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = Task::factory()->make()->only('name', 'description', 'status_id', 'assigned_to_id');
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testEdit()
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.edit', $task));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $task = Task::factory()->create();
        $data = Task::factory()->make()->only('name', 'description', 'status_id', 'assigned_to_id');
        $response = $this->patch(route('tasks.update', $task), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy()
    {
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }
}
