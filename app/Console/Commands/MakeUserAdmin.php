<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make {email : The email address of the user to make admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an administrator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        if ($user->is_admin) {
            $this->info("User '{$user->name}' ({$user->email}) is already an administrator.");
            return 0;
        }
        
        $user->update(['is_admin' => true]);
        
        $this->info("User '{$user->name}' ({$user->email}) has been made an administrator.");
        $this->line('They can now access the admin dashboard at: ' . url('/admin'));
        
        return 0;
    }
}
