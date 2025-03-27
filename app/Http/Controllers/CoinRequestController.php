<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoinRequestCreateRequest;
use App\Models\CoinRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoinRequestController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAnyCoinRequest', auth()->user());

        $requests = auth()->user()->coinRequestedFromMe()
            ->with('user')->orderBy('created_at', 'asc')->get()->groupBy('status');
        $pendingRequests = $requests->get(0, collect());
        $approvedRequests = $requests->get(1, collect());

        return Inertia::render('coinRequest/Index', [
            'pending_requests' => $pendingRequests,
            'approved_requests' => $approvedRequests,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CoinRequestCreateRequest $request)
    {
        $this->authorize('create', CoinRequest::class);

        if ($request->type === 2 && empty($request->credit_days)) {
            return response()->json(['error' => 'Credit days are required for credit requests.'], 422);
        }

        // File Upload Logic (if necessary)
        foreach (['proof_1', 'proof_2', 'proof_3'] as $proof) {
            if ($request->hasFile($proof)) {
                $request->$proof = $request->file($proof)->store('proofs', 'public');
            }
        }

        $request['user_id'] = auth()->id();
        $request['requested_from'] = 1;
        $request['status'] = 0;

        $coinRequest = CoinRequest::create($request->validated());

        return redirect()->route('coinRequest.show', $coinRequest);

    }

    public function update(Request $request, CoinRequest $coinRequest)
    {
        $this->authorize('update', $coinRequest);

        $request->validate([
            'status' => 'required|integer|in:1,2',
        ]);

        $coinRequest->update([
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('coinRequest.index');
    }
}
