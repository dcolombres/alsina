<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);

        $userRole = Role::create(['name' => 'Usuario']);

        // create demo users
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@alsina.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@alsina.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($userRole);
    }
}
