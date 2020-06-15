<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function showLoginPage()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
    }
}
