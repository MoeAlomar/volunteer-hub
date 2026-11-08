<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {username? : Admin username} {--password= : Password (prompted if omitted)}';

    protected $description = 'Create an admin, or reset the password of an existing one';

    public function handle(): int
    {
        $username = $this->argument('username') ?: $this->ask('Username');
        $password = $this->option('password') ?: $this->secret('Password (min 8 characters)');

        if (! is_string($username) || ! preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) {
            $this->error('Username must be 3-50 characters: letters, digits, _ . -');

            return self::FAILURE;
        }

        if (! is_string($password) || strlen($password) < 8) {
            $this->error('Password must be at least 8 characters.');

            return self::FAILURE;
        }

        $admin = Admin::updateOrCreate(
            ['username' => $username],
            ['password_hash' => Hash::make($password)],
        );

        $this->info($admin->wasRecentlyCreated ? "Admin '{$username}' created." : "Password for '{$username}' updated.");

        return self::SUCCESS;
    }
}
