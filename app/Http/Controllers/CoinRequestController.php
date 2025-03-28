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
            ->with('user')->orderBy('created_at', 'desc')
            ->get()->groupBy('status');

        $myRequests = auth()->user()->coinRequests()
            ->orderBy('created_at', 'desc')
            ->get()->groupBy('status');

        return Inertia::render('coinRequest/Index', [
            'pending_requests' => $requests->get(1, collect()),
            'approved_requests' => $requests->get(2, collect()),
            'my_pending_requests' => $myRequests->get(1, collect()),
            'my_approved_requests' => $myRequests->get(2, collect()),
        ]);
    }

    public function show(CoinRequest $coinRequest)
    {
        $this->authorize('view', $coinRequest);

        return Inertia::render('coinRequest/Show', ['coinRequest' => $coinRequest->load('user')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoinRequestCreateRequest $request)
    {
        $this->authorize('create', CoinRequest::class);

        $data = [
            'type' => $request->type,
            'amount' => $request->amount,
            'credit_days' => $request->credit_days,
            'message' => $request->message,
        ];

        if ($data['type'] === 2 && empty($data['credit_days'])) {
            return response()->json(['error' => 'Credit days are required for credit requests.'], 422);
        }

        // File Upload Logic (if necessary)
        foreach (['proof_1', 'proof_2', 'proof_3'] as $proof) {
            if ($request->hasFile($proof)) {
                $file = $request->file($proof);

                $filename = time().'_'.$file->getClientOriginalName();

                $path = $file->storeAs('proofs', $filename, 'public');
                $data[$proof] = $path;
            }
        }

        $data['user_id'] = auth()->id();
        $data['requested_from'] = 1;
        $data['status'] = 1;

        $coinRequest = CoinRequest::create($data);

        return redirect()->route('coinRequest.show', $coinRequest);

    }

    public function create(Request $request)
    {
        $this->authorize('create', CoinRequest::class);

        return Inertia::render('coinRequest/Create');
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
