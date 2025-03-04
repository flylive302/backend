<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Str;

class SignatureHelper
{
    /**
     * Generate a unique signature based on the user's name.
     *
     * @param string $name
     * @return string
     */
    public static function generate($name)
    {
        $signature = '#' . Str::slug($name, '_') . '_' . Str::random(6);

        // Ensure uniqueness in the users table
        while (User::where('signature', $signature)->exists()) {
            $signature = '#' . Str::slug($name, '_') . '_' . Str::random(6); // Generate a Unique Slug again
        }

        return $signature;
    }
}
