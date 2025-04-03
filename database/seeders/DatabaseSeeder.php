<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin user',
            'phone' => '+923005274302',
            'email' => 'admin@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'pk',
            'password' => Hash::make('password'),
            'signature' => '@admin',
            'coin_balance' => 10000
        ]);

        User::create([
            'name' => 'Reseller user',
            'phone' => '+923005274303',
            'email' => 'reseller@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'uk',
            'password' => Hash::make('password'),
            'signature' => '@reseller',
        ]);

        User::create([
            'name' => 'Admin Irfan',
            'phone' => '+923005274304',
            'email' => 'adminirfan@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'pk',
            'password' => Hash::make('password'),
            'signature' => '@AdminIrfanTheOGReseller',
        ]);

//        User::factory(10)->create();

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(FrameSeeder::class);
    }
}
