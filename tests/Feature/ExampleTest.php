<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
  /**
   * A basic test example.
   */
  public function test_the_application_returns_a_successful_response(): void
  {
    $response = $this->get('http://10.1.1.50:8000/api/embalagens/buscar');

    $response->assertStatus(200);
  }
}
