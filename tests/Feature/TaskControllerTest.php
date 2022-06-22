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
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
     //   Task::factory()->count(2)->make();
    //    $task = Task::factory()->count(2)->make();
    //    dd($task);
    //    TaskStatus::factory()->count(2)->make();
    //    $taskStatus = TaskStatus::factory()->count(2)->make();
    //    dd($taskStatus);

        $this->user = User::factory()->create();
 //       dd($this->user);
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
        //     dd($task);
        //    $taskStatus = TaskStatus::factory()->count(2)->make();
        $response = $this->get(route('tasks.show', $task));
        //   dd($response);
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
     //   dd($data);
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $data);
    //    dd($response);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testEdit()
    {
        $task = Task::factory()->create();
        //    dd($task);
        //    $taskStatus = TaskStatus::factory()->count(2)->make();
        $response = $this->get(route('tasks.edit', $task));
        //   dd($response);
        $response->assertOk();
    }

    public function testUpdate()
    {
        $task = Task::factory()->create();
        //     dd($task);
        $data = Task::factory()->make()->only('name', 'description', 'status_id', 'assigned_to_id');
        //     dd($data);

        $response = $this->patch(route('tasks.update', $task), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy()
    {
        $task = Task::factory()->create();
        //      dd($task);
        $response = $this->delete(route('tasks.destroy', $task));
        //     dd($response);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }
}
