<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * Test for valid credentials login.
     *
     * @return void
     */
    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post(
            route('auth.login'),
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token', 'profile'
                ]
            ]);

        $this->assertNotNull($response->json('data.access_token'), 'No access token given.');
        $this->assertEquals($user->email, $response->json('data.profile.email'));
    }

    /**
     * Test for invalid credentials login
     *
     * @return void
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post(
            route('auth.login'),
            [
                'email' => $user->email,
                'password' => 'wrong_password',
            ]
        );

        $response->assertStatus(400);
    }
}
