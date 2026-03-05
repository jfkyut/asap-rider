<?php

namespace App\Http\Controllers;

use App\Models\Delivery\Delivery;
use Illuminate\Http\Request;

class DeliveryFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Delivery $delivery, Request $request)
    {
        $validated = $request->validate([
            'comment' => 'nullable',
            'star_count' => 'required',
        ]);

        $delivery->feedbacks()->create([
            'comment' => $validated['comment'],
            'star_count' => $validated['star_count'],
            'user_id' => $request->user()->id
        ]);

        return back();
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
