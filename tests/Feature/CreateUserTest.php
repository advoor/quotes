<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_user_with_valid_data()
    {
        $this->artisan('app:create-user')
            ->expectsQuestion('What is your name?', 'John Doe')
            ->expectsQuestion('What should the email address be? (Must be unique!)', 'john@example.com')
            ->expectsQuestion('What should the password be?', 'password123')
            ->expectsOutput('Creating a new user...')
            ->expectsOutput('User created successfully!')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_it_does_not_create_user_with_duplicate_email()
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $this->artisan('app:create-user')
            ->expectsQuestion('What is your name?', 'Jane Doe')
            ->expectsQuestion('What should the email address be? (Must be unique!)', 'duplicate@example.com')
            ->expectsQuestion('What should the email address be? (Must be unique!)', 'jane@example.com')
            ->expectsQuestion('What should the password be?', 'password123')
            ->expectsOutput('Creating a new user...')
            ->expectsOutput('User created successfully!')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_it_requires_a_password()
    {
        $this->artisan('app:create-user')
            ->expectsQuestion('What is your name?', 'John Doe')
            ->expectsQuestion('What should the email address be? (Must be unique!)', 'john@example.com')
            ->expectsQuestion('What should the password be?', '')
            ->expectsQuestion('What should the password be?', 'password123')
            ->expectsOutput('Creating a new user...')
            ->expectsOutput('User created successfully!')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
