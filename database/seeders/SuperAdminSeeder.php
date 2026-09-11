<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@karibu.tech'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@2026!'),
                'role' => Role::SUPER_ADMIN->value,
                'is_active' => true,
            ]
        );
    }
}
