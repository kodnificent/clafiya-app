<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a test user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'hello@example.com';
        $user->password = Hash::make('password');
        $user->email_verified_at = now();
        $user->save();

        return $this->info('User created successfully.');
    }
}
