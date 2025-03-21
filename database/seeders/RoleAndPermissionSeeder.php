<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view_users', 'description' => 'Can view users list'],
            ['name' => 'create_users', 'description' => 'Can create new users'],
            ['name' => 'edit_users', 'description' => 'Can edit existing users'],
            ['name' => 'delete_users', 'description' => 'Can delete users'],

            ['name' => 'view_exercises', 'description' => 'Can view exercises list'],
            ['name' => 'create_exercises', 'description' => 'Can create new exercises'],
            ['name' => 'edit_exercises', 'description' => 'Can edit existing exercises'],
            ['name' => 'delete_exercises', 'description' => 'Can delete exercises'],

            ['name' => 'view_meals', 'description' => 'Can view meals list'],
            ['name' => 'create_meals', 'description' => 'Can create new meals'],
            ['name' => 'edit_meals', 'description' => 'Can edit existing meals'],
            ['name' => 'delete_meals', 'description' => 'Can delete meals'],
        ];

        foreach($permissions as $permission) {
            Permission::create($permission);
        }

        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Full access to all features'
        ]);

        $coachRole = Role::create([
            'name' => 'coach',
            'description' => 'create plans'
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'description' => 'normal user can create his plans and purchase plans'
        ]);
//        dd(Permission::all()->pluck('id')->toArray());
        $adminRole->givePermissionTo(Permission::all()->pluck('id')->toArray());

    }
}
