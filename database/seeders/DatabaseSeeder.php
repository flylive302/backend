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
        $admin = User::create([
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

        $admin->room()->create([
            'name' => $admin->signature,
            'country' => $admin->country,
        ]);

        $reseller1 = User::create([
            'name' => 'Reseller user',
            'phone' => '+923005274303',
            'email' => 'reseller@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'uk',
            'password' => Hash::make('password'),
            'signature' => '@reseller',
        ]);

        $reseller1->room()->create([
            'name' => $reseller1->signature,
            'country' => $reseller1->country,
        ]);

        $reseller2 = User::create([
            'name' => 'Admin Irfan',
            'phone' => '+923005274304',
            'email' => 'adminirfan@flylive.com',
            'gender' => 'male',
            'dob' => '1999-01-01',
            'country' => 'pk',
            'password' => Hash::make('password'),
            'signature' => '@AdminIrfanTheOGReseller',
        ]);

        $reseller2->room()->create([
            'name' => $reseller2->signature,
            'country' => $reseller2->country,
        ]);

//        User::factory(10)->create();

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(FrameSeeder::class);
    }
}
