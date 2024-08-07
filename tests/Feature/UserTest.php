<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_credentials_return_unauthorized()
    {
        $user = User::factory()->create(['password' => Hash::make('correctpassword')]);

        $response = $this->postJson('/api/authenticate', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid credentials']);
    }

    public function test_valid_credentials_return_token()
    {
        $user = User::factory()->create(['password' => Hash::make('correctpassword')]);

        $response = $this->postJson('/api/authenticate', [
            'email' => $user->email,
            'password' => 'correctpassword',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_profile_returns_user_data()
    {
        $token = Str::random(80);
        User::factory(
            ['api_token' => Hash::make($token)]
        )->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/profile');

        $response->assertStatus(200);
        $response->assertJsonStructure(['name', 'email']);
    }

    public function test_profile_returns_unauthorized_without_token()
    {
        $response = $this->getJson('/api/profile');

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthorized']);
    }
}
