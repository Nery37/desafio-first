<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_user_success()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson(route('register'), $userData);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function test_create_user_validation_failure()
    {
        $userData = [
            'password' => 'password123',
        ];

        $response = $this->postJson(route('register'), $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password_confirmation']);
    }
}
