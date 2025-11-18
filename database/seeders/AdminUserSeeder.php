<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@halmazing.com');
        $password = env('ADMIN_PASSWORD', '@HalmazingAdmin123!');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Site Admin',
                'password' => Hash::make($password),
                'dob' => now()->subYears(30)->toDateString(),
                'is_admin' => true,
                'merchant_status' => 'none',
            ]
        );

        // Ensure is_admin flag is set
        if (! $user->is_admin) {
            $user->is_admin = true;
            $user->save();
        }
    }
}
