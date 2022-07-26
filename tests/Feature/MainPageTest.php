<?php

namespace Tests\Feature;

use Tests\TestCase;

class MainPageTest extends TestCase
{
    /**
     *
     * @return void
     */

    public function testWelcome(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertOk();
    }
}
