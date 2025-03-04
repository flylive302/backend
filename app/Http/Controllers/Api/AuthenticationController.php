<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SignatureHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthenticationController extends Controller
{

    public function authUser(Request $request)
    {
        $user = $request->user();

        $permissionNames = DB::table('permissions as p')
            ->join('role_has_permissions as rp', 'p.id', '=', 'rp.permission_id')
            ->join('model_has_roles as mr', 'rp.role_id', '=', 'mr.role_id')
            ->where('mr.model_id', $user->id)
            ->where('mr.model_type', $user->getMorphClass())
            ->distinct()
            ->pluck('p.name');

        $user['permissions'] = $permissionNames;

        return $user;
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+[1-9]\d{1,14}$/', 'unique:users,phone'], // Ensures valid E.164 format
            'country' => ['required', 'string', 'size:2'], // 2-character country code (ISO 3166-1 alpha-2)
            'gender' => ['required', 'string', 'in:male,female,others', 'lowercase'],
            'dob' => ['required', 'date', 'before:'. now()->subYears(2)->format('Y-m-d')],
            'password' => ['required', 'string', Password::defaults()], // Secure password rules
            'avatarFile' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:4050']
        ]);

        // Generate signature
        $validatedData['signature'] = SignatureHelper::generate($validatedData['name']);

        // Hash password securely
        $validatedData['password'] = Hash::make($request->input('password'));
        
        $validatedData['email'] = 'stfox302@gmail.com';

        // Create user
        $user = User::create($validatedData);

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }


    public function login(ApiLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->authenticate();

        return response()->json([
            'token' => $request->user()->createToken('auth_token')->plainTextToken,
        ]);
    }


    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You have been successfully logged out.',
        ]);
    }
}
