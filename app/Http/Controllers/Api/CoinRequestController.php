<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoinRequestCreateRequest;
use App\Models\CoinRequest;
use App\Models\User;

class CoinRequestController extends Controller
{

    public function getCoinResellers()
    {
        $resellers = User::role('reseller')->select([
            'id', 'name', 'signature', 'avatar_image', 'coin_balance'
        ])->get();

        return response()->json($resellers);
    }

    public function store(User $user, CoinRequestCreateRequest $request)
    {
        $data = $request->validated();

        if ($data['type'] === 2 && empty($data['credit_days'])) {
            return back()->withErrors(['credit_days' => 'Credit days are required for credit requests.'])->withInput();
        }

        // Handle file uploads securely
        foreach (['proof_1', 'proof_2', 'proof_3'] as $proof) {
            if ($file = $request->file($proof)) {
                $data[$proof] = $file->store('proofs', 'public');
            }
        }

        $data['user_id'] = auth()->id();
        $data['requested_from'] = $user->id;

        $coinRequest = CoinRequest::create($data);

        return response()->json($coinRequest);
    }
}
