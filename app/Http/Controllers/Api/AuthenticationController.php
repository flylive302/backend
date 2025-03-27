<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SignatureHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;

class AuthenticationController extends Controller
{

    public function authUser(Request $request)
    {
        $user = $request->user();

        $user['can'] = $user?->getPermissionsViaRoles()
            ->map(function (Permission $permission): array {
                return [$permission['name'] => auth()->user()->can($permission['name'])];
            })
            ->collapse()->all();

        $user['active_frame'] = $user->where('is_active', true)->first();

        return $user;
    }

    public function getUserById(User $user)
    {
        return $user;
    }

    public function register(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+[1-9]\d{1,14}$/', Rule::unique('users', 'phone')],
            // Ensures valid E.164 format
            'country' => ['required', 'string', 'size:2'], // 2-character country code (ISO 3166-1 alpha-2)
            'gender' => ['required', 'string', Rule::in(['male', 'female', 'others']), 'lowercase'],
            'dob' => ['required', 'date', 'before:-18 years'],
            'password' => ['required', 'string', Password::defaults()], // Secure password rules
        ]);

        $validatedData['signature'] = SignatureHelper::generate($validatedData['name']);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $validatedData['email'] = $validatedData['signature'].'@flylive.com';

        $user = User::create($validatedData);

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }


    public function login(ApiLoginRequest $request): JsonResponse
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

    public function updateProfileField(Request $request): JsonResponse
    {
        $rules = [
            'name' => ['string', 'max:100'],
            'phone' => ['string', 'max:20', 'regex:/^\+[1-9]\d{1,14}$/'],
            'country' => ['string', 'size:2'],
            'gender' => ['string', 'in:male,female,others', 'lowercase'],
            'dob' => ['date', 'before:-18 years'],
            'signature' => ['string'],
            'password' => ['string', Password::defaults()],
            'avatar_image' => ['string'], // Consider changing this if it's a file
        ];

        $field = $request->input('field');

        if (!array_key_exists($field, $rules)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid field selected for update.',
            ], 422);
        }

        if (in_array($field, ['phone', 'signature'])) {
            $rules[$field][] = Rule::unique('users', $field)->ignore($request->user()->id);
        }

        $validated = $request->validate([
            'field' => ['required', 'string', Rule::in(array_keys($rules))],
            'value' => $rules[$field],
        ]);

        $user = $request->user();

        if ($user->$field === $validated['value']) {
            return response()->json([
                'status' => 'success',
                'message' => ucfirst($field).' is already set to this value.',
            ]);
        }

        DB::transaction(function () use ($user, $field, $validated) {
            if ($field === 'password') {
                $user->password = Hash::make($validated['value']);
            } else {
                $user->$field = $validated['value'];
            }
            $user->save();
        });

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($field).' updated successfully.',
        ]);

    }


    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You have been successfully logged out.',
        ]);
    }
}
