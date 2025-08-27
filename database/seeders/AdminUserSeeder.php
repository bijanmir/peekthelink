<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $adminEmail = env('ADMIN_EMAIL', 'admin@peekthelink.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Diamond18!');
        
        $existingAdmin = User::where('email', $adminEmail)->first();
        
        if ($existingAdmin) {
            // Update existing user to be admin
            $existingAdmin->update([
                'is_admin' => true,
                'is_active' => true
            ]);
            
            $this->command->info("Existing user {$adminEmail} promoted to admin.");
        } else {
            // Create new admin user
            User::create([
                'name' => env('ADMIN_NAME', 'Administrator'),
                'username' => env('ADMIN_USERNAME', 'admin'),
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info("Admin user created: {$adminEmail}");
        }
        
        $this->command->warn("⚠️  Remember to change the default password!");
        $this->command->info("You can access admin dashboard at: " . url('/admin'));
    }
}
