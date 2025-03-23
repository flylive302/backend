<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use function Laravel\Prompts\error;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getFrames()
    {
        return response()->json(Frame::all());
    }

    public function getMyFrames()
    {
        return response()->json(auth()->user()->frames);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function purchase(Frame $frame): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        // Check if user has enough balance
        if ($user->coin_balance < $frame->price) {
            return response()->json(['error' => 'Insufficient funds.'], 400);
        }

        // Retrieve existing frame from user's collection
        $existingFrame = $user->frames()->where('frame_id', $frame->id)->first();

        // Calculate new expiry date
        $newExpiry = $frame->valid_duration
            ? $existingFrame
                ? Carbon::parse($existingFrame->pivot->expires_at)->addSeconds($frame->valid_duration)
                : now()->addSeconds($frame->valid_duration)
            : null;

        // Prepare data to update or attach
        $updateData = [
            'quantity' => $existingFrame ? $existingFrame->pivot->quantity + 1 : 1,
            'expires_at' => $newExpiry,
        ];

        // Update or attach frame to user
        if ($existingFrame) {
            $user->frames()->updateExistingPivot($frame->id, $updateData);
        } else {
            $user->frames()->attach($frame->id, $updateData);
        }

        return response()->json(['message' => 'Frame attached to user successfully.']);
    }

    public function activate(Frame $frame): \Illuminate\Http\JsonResponse
    {
        auth()->user()->frames()->where('is_active', true)->update(['is_active' => false]);
        auth()->user()->frames()->updateExistingPivot($frame->id, ['is_active' => true]);

        return response()->json([
            'message' => 'Frame Activated successfully.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
