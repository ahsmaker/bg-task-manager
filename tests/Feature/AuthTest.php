<?php


namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_has_validation_error()
    {
        $response = $this->postJson('/api/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'short',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $user->refresh();

        $response->assertStatus(200)
            ->assertJsonStructure(['token_type', 'access_token'])
            ->assertJson([
                'token_type'   => 'Bearer',
            ]);
    }

    public function test_password_validation()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(401);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => '',
        ]);

        $response->assertStatus(422);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
        ]);

        $response->assertStatus(422);
    }
}
