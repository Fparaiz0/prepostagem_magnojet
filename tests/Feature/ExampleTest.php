<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
  public function test_the_application_returns_a_successful_response(): void
  {
    $response = $this->get('http://10.0.0.50:8000/api/remetentes/buscar');

    $response->assertStatus(200);
  }
}
