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
            ['name' => 'View Users', 'description' => 'Can view users list', 'slug' => 'view-users', 'module' => 'users'],
            ['name' => 'Create Users', 'description' => 'Can create new users', 'slug' => 'create-users', 'module' => 'users'],
            ['name' => 'Edit Users', 'description' => 'Can edit existing users', 'slug' => 'edit-users', 'module' => 'users'],
            ['name' => 'Delete Users', 'description' => 'Can delete users', 'slug' => 'delete-users', 'module' => 'users'],

            ['name' => 'View Exercises', 'description' => 'Can view exercises list', 'slug' => 'view-exercises', 'module' => 'exercises'],
            ['name' => 'Create Exercises', 'description' => 'Can create new exercises', 'slug' => 'create-exercises', 'module' => 'exercises'],
            ['name' => 'Edit Exercises', 'description' => 'Can edit existing exercises', 'slug' => 'edit-exercises', 'module' => 'exercises'],
            ['name' => 'Delete Exercises', 'description' => 'Can delete exercises', 'slug' => 'delete-exercises', 'module' => 'exercises'],

            ['name' => 'View Meals', 'description' => 'Can view meals list', 'slug' => 'view-meals', 'module' => 'meals'],
            ['name' => 'Create Meals', 'description' => 'Can create new meals', 'slug' => 'create-meals', 'module' => 'meals'],
            ['name' => 'Edit Meals', 'description' => 'Can edit existing meals', 'slug' => 'edit-meals', 'module' => 'meals'],
            ['name' => 'Delete Meals', 'description' => 'Can delete meals', 'slug' => 'delete-meals', 'module' => 'meals'],
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
