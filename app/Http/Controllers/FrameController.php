<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrameCreateRequest;
use App\Models\Frame;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('frame/Index', ['frames' => Frame::all(), 'count' => Frame::count()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('frame/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FrameCreateRequest $request)
    {
        Frame::create($request->validated());

        return redirect()->route('frame.index');
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
