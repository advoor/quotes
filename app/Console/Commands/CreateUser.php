<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user for this API.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new user...');

        $name = $this->ask('What is your name?', 'Test Person');

        do {
            $email = $this->ask('What should the email address be? (Must be unique!)', 'test@example.com');
            if (User::query()->where('email', $email)->exists()) {
                $this->error('The email address is already taken. Please provide a unique email address.');
            }
        } while (User::query()->where('email', $email)->exists());

        // In a production environment, should have validation for password strength + confirmation.
        // This is just a simple example.
        do {
            $password = $this->secret('What should the password be?');
            if (strlen($password) < 8) {
                $this->error('Password must be at least 8 characters long.');
            }
        } while (strlen($password) < 8);

        // Ideally we should be using Sanctum or Passport for API tokens
        $apiToken = Str::random(80);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'api_token' => Hash::make($apiToken),
        ]);

        $this->info('User created successfully!');
        $this->info("API token: {$apiToken}");
    }
}
