<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoinRequestCreateRequest;
use App\Models\CoinRequest;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CoinRequestController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAnyCoinRequest', auth()->user());

        $requests = auth()->user()->coinRequestedFromMe()
            ->with('user')->orderBy('created_at', 'desc')
            ->get()->groupBy('status');

        $myRequests = auth()->user()->coinRequests()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()->groupBy('status');

        return Inertia::render('coinRequest/Index', [
            'pending_requests' => $requests->get(1, collect()),
            'approved_requests' => $requests->get(2, collect()),
            'rejected_requests' => $requests->get(3, collect()),
            'my_pending_requests' => $myRequests->get(1, collect()),
            'my_approved_requests' => $myRequests->get(2, collect()),
            'my_rejected_requests' => $myRequests->get(3, collect()),
        ]);
    }

    public function show(CoinRequest $coinRequest)
    {
        $this->authorize('view', $coinRequest);

        return Inertia::render('coinRequest/Show', ['coinRequest' => $coinRequest->load('user')]);
    }

    public function store(CoinRequestCreateRequest $request)
    {
        $this->authorize('create', CoinRequest::class);

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
        $data['requested_from'] = 1;
        $data['status'] = 1;

        $coinRequest = CoinRequest::create($data);

        return redirect()->route('coinRequest.show', $coinRequest->id)->with('success',
            'Coin request created successfully.');
    }

    public function create(Request $request)
    {
        $this->authorize('create', CoinRequest::class);

        return Inertia::render('coinRequest/Create');
    }

    public function update(Request $request, CoinRequest $coinRequest)
    {
        $this->authorize('update', $coinRequest);

        $validatedData = $request->validate([
            'status' => ['required', 'integer', 'in:1,2,3'],
            'action_message' => ['nullable', 'string', 'max:255'],
        ]);

        $validatedData['updated_by'] = auth()->id();

        if ($validatedData['status'] === 3) {
            $coinRequest->update($validatedData);

            return redirect()->route('coinRequest.show', $coinRequest->id);
        }

        $requestedFrom = $coinRequest->requestedFrom;
        $requestingUser = $coinRequest->user;

        if ($requestedFrom->coin_balance < $coinRequest->amount) {
            return redirect()->route('coinRequest.show', $coinRequest->id)
                ->withErrors(['errors' => 'You do not have enough coins to approve this request.']);
        }

        DB::transaction(function () use ($coinRequest, $requestedFrom, $requestingUser, $validatedData) {
            $requestedFrom->decrement('coin_balance', $coinRequest->amount);
            $requestingUser->increment('coin_balance', $coinRequest->amount);

            Transaction::create([
                'user_id' => $requestedFrom->id,
                'beneficiary_id' => $requestingUser->id,
                'before' => $requestedFrom->coin_balance + $coinRequest->amount,
                'after' => $requestedFrom->coin_balance,
                'transactionable_id' => $coinRequest->id,
                'transactionable_type' => get_class($coinRequest),
                'real_value' => $coinRequest->amount,
                'change_in_value' => $coinRequest->amount,
            ]);

            $coinRequest->update($validatedData);
        });

        return redirect()->route('coinRequest.index');
    }
}
