<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use RefreshDatabase;

    protected ?string $authToken;

    public function setUp(): void
    {
        parent::setUp();

        $this->authToken = Str::random(80);
        $this->user = User::factory(
            ['api_token' => Hash::make($this->authToken)]
        )->create();
    }

    public function test_it_cant_access_quotes_endpoint_without_auth()
    {
        $response = $this->getJson('/api/quotes');
        $response->assertStatus(401);
    }

    public function test_it_returns_quotes_when_no_fresh_parameter()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authToken])
            ->getJson('/api/quotes');
        $response->assertStatus(200);
        $response->assertJsonStructure([['quote']]);
    }

    public function test_it_refreshes_and_returns_quotes_when_fresh_parameter_is_present()
    {
        Quote::shouldReceive('refresh')->once();
        Quote::shouldReceive('get')->once()->andReturn([['quote' => 'Test quote']]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authToken])
            ->getJson('/api/quotes?fresh=true');
        $response->assertStatus(200);
        $response->assertJson([['quote' => 'Test quote']]);
    }

    public function test_it_returns_empty_array_when_no_quotes_available()
    {
        Quote::shouldReceive('get')->once()->andReturn([]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->authToken])
            ->getJson('/api/quotes');
        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
