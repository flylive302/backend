<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'viewAnyUser', 'viewUser',
            'viewAnyFrame',
            'viewAnyCoinRequest', 'createCoinRequest', 'updateCoinRequest'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminPermissions = [
            'viewAnyUser', 'viewUser',
            'viewAnyCoinRequest', 'updateCoinRequest',
            'viewAnyFrame',
        ];

        $resellerPermissions = ['viewAnyCoinRequest', 'createCoinRequest'];

        Role::firstOrCreate(['name' => 'admin'])->givePermissionTo($adminPermissions);
        Role::firstOrCreate(['name' => 'reseller'])->givePermissionTo($resellerPermissions);

        User::find(1)?->assignRole('admin');
        User::find(2)?->assignRole('reseller');
        User::find(3)?->assignRole('reseller');
    }
}
