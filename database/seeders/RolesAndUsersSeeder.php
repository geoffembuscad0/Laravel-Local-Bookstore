<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder{
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Privileged users are only created when credentials are explicitly
        // supplied through the environment. This prevents seeding a known
        // privileged password into a real database.
        if ($email = env('SEED_SUPER_ADMIN_EMAIL')) {
            $superAdmin = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => env('SEED_SUPER_ADMIN_NAME', 'Super Admin'),
                    'password' => env('SEED_SUPER_ADMIN_PASSWORD'),
                ]
            );

            $superAdmin->assignRole($superAdminRole);
        }

        if ($email = env('SEED_ADMIN_EMAIL')) {
            $admin = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => env('SEED_ADMIN_NAME', 'Default Admin'),
                    'password' => env('SEED_ADMIN_PASSWORD'),
                ]
            );

            $admin->assignRole($adminRole);
        }

        // Create sample regular users
        for ($i = 1; $i <= 5; $i) {
            $user = User::firstOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => "Sample User {$i}", 'password' => 'password123'
                ]
            );
            $user->assignRole($userRole);
        }
    }
}
