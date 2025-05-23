<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FrameController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Frame::all());
    }

    public function getMyFrames(): JsonResponse
    {
        return response()->json(auth()->user()->frames);
    }

    public function purchase(Frame $frame): JsonResponse
    {
        $user = auth()->user();

        // Check if user has enough balance
        if ($user->coin_balance < $frame->price) {
            return response()->json(['error' => 'Insufficient funds.'], 400);
        }

        // Retrieve existing frame from user's collection
        $existingFrame = $user->frames()->where('frame_id', $frame->id)->first();

        // Calculate new expiry date
        if ($frame->valid_duration) {
            if ($existingFrame) {
                $newExpiry = Carbon::parse($existingFrame->pivot->expires_at)->addSeconds($frame->valid_duration);
            } else {
                $newExpiry = now()->addSeconds($frame->valid_duration);
            }
        } else {
            $newExpiry = null;
        }

        // Prepare data to update or attach
        if ($existingFrame) {
            $quantity = $existingFrame->pivot->quantity + 1;
        } else {
            $quantity = 1;
        }

        $updateData = [
            'quantity' => $quantity,
            'expires_at' => $newExpiry,
        ];

        $user->decrement('coin_balance', $frame->price);
        User::find(1)->increment('coin_balance', $frame->price);

        // Update or attach frame to user
        if ($existingFrame) {
            $user->frames()->updateExistingPivot($frame->id, $updateData);
        } else {
            $user->frames()->attach($frame->id, $updateData);
        }

        Transaction::create([
            'user_id' => $user->id,
            'beneficiary_id' => 1,
            'transactionable_id' => $frame->id,
            'transactionable_type' => Frame::class,
            'currency_type' => 1,
            'quantity' => 1,
            'real_value' => $frame->price,
            'change_in_value' => $frame->price,
            'before' => $user->coin_balance,
            'after' => $user->coin_balance - $frame->price,
        ]);

        return response()->json(['message' => 'Frame attached to user successfully.']);
    }

    public function activate(Frame $frame): JsonResponse
    {
        DB::table('frame_user')->where('user_id', auth()->id())->where('is_active', true)->update([
            'is_active' => false,
            'updated_at' => now()
        ]);
        auth()->user()->frames()->updateExistingPivot($frame->id, ['is_active' => true]);

        auth()->user()->update([
            'animated_src' => $frame->animated_src,
            'static_src' => $frame->static_src,
        ]);

        return response()->json([
            'message' => 'Frame Activated successfully.',
        ]);
    }
}
