<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);
        
        // Create superadmin user if it doesn't exist
        $superadmin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );
        
        // Assign superadmin role
        if (!$superadmin->hasRole('superadmin')) {
            $superadmin->assignRole('superadmin');
        }
        
        $this->command->info('Superadmin user created: admin@admin.com / password');
    }
}
