<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['pet_owner', 'service_provider', 'admin'];

        foreach ($names as $name) {
            \App\Models\Role::updateOrCreate(['name' => $name], []);
        }

        // Attach roles to users that already store role in column `users.role`
        // (existing project seeder uses this column).
        $users = \App\Models\User::query()->get();

        foreach ($users as $user) {
            if (!empty($user->role)) {
                $role = \App\Models\Role::query()->where('name', $user->role)->first();
                if ($role) {
                    $user->roles()->syncWithoutDetaching([$role->id]);
                }
            }
        }
    }

}
