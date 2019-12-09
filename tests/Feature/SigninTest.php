<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SigninTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_sign_up()
    {
        $user = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'secret'
        ];

        $response = $this->post('/api/auth/signup', [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }
}
