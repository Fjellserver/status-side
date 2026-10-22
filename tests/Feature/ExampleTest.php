<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_status_page_renders(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
