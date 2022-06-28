<?php

namespace Tests\Feature;

use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Label::factory()->count(2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
      //  dd($response);
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = Label::factory()->make()->only('name', 'description');
   //     dd($data);
        $response = $this->post(route('labels.store'), $data);
      //  dd($response);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testEdit()
    {
        $label = Label::factory()->create();
        //    dd($label);
        $response = $this->get(route('labels.edit', [$label]));
        //dd($response) ;
        $response->assertOk();
    }

    public function testUpdate()
    {
        $label = Label::factory()->create();
        //     dd($label);
        $data = Label::factory()->make()->only('name', 'description');
        //     dd($data);

        $response = $this->patch(route('labels.update', $label), $data);
        //dd($response);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $label = Label::factory()->create();
         //     dd($label);
        $response = $this->delete(route('labels.destroy', [$label]));
      //       dd($response);
      //  dd($label->only('id'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', $label->only('id'));
    }

}

