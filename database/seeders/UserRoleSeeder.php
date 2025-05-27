<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $user = User::first();
        if ($user && $adminRole) {
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
