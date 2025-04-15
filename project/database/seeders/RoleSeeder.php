<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Define default roles
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator with full privileges',
            ],
            [
                'name' => 'user',
                'description' => 'Regular user with limited access',
            ],
            [
                'name' => 'moderator',
                'description' => 'User with moderation privileges',
            ],
        ];

        // Insert each role if it doesn't exist
        foreach ($roles as $role) {
            Role::query()->firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
