<?php

namespace Database\Seeders;

use App\Models\Frame;
use Illuminate\Database\Seeder;

class FrameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Frame::create([
            'name' => 'Default',
            'price' => 0,
            'static_src' => 'ladies-frame.webp',
            'animated_src' => 'ladies-frame',
            'status' => 1,
        ]);

        Frame::create([
            'name' => 'Test With Expiry',
            'price' => 150,
            'static_src' => 'default-frame.webp',
            'animated_src' => '1',
            'status' => 1,
            'valid_duration' => '985016'
        ]);

        Frame::create([
            'name' => 'Test Without Expiry',
            'price' => 500,
            'static_src' => '1.webp',
            'animated_src' => '2',
            'status' => 2,
            'valid_duration' => '985016'
        ]);
    }
}
