<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasuyo\Pasuyo;
use App\Models\PickAndDrop\PickAndDrop;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Delivery/Delivery', [
            'jobs' => [
                'pasuyos' => Pasuyo::where('status', 'pending')
                                   ->whereDoesntHave('delivery')
                                   ->latest()
                                   ->get(),
                'pick_and_drops' => PickAndDrop::where('status', 'pending')
                                               ->whereDoesntHave('delivery')
                                               ->latest()
                                               ->get(),
            ]
        ]);
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
