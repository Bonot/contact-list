<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_login_with_valid_credentials()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $this->assertTrue(strlen($response->getData()) > 0);
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
                ->assertContent('"Unauthorized"');
    }
}
