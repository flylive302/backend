<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'phone' => '+923005274302',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'pk',
            'password' => Hash::make('3005274302'),
        ]);

        User::factory(10)->create();
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
