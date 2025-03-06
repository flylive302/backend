<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SignatureHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

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
        ]);

        $validatedData['signature'] = SignatureHelper::generate($validatedData['name']);

        $validatedData['password'] = Hash::make($request->input('password'));

        $validatedData['email'] = $validatedData['signature'].'@gmail.com';

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

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully.',
        ]);
    }

    public function updateProfileField(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validate only allowed fields for update
        $rules = [
            'name' => ['string', 'max:100'],
            'phone' => ['string', 'max:20', 'regex:/^\+[1-9]\d{1,14}$/', 'unique:users,phone'],
            'country' => ['string', 'size:2'],
            'gender' => ['string', 'in:male,female,others', 'lowercase'],
            'dob' => ['date', 'before:' . now()->subYears(2)->format('Y-m-d')],
            'signature' => ['string', 'unique:users,signature'],
            'password' => ['string', Password::defaults()],
        ];

        $validated = $request->validate([
            'field' => 'required|string|in:' . implode(',', array_keys($rules)),
            'value' => $rules[$request->input('field')],
        ]);

        $user = $request->user();
        $field = $validated['field'];
        $user->$field = $validated['value'];
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($field) . ' updated successfully.',
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
