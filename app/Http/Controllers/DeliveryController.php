<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasuyo\Pasuyo;
use App\Models\Delivery\Delivery;
use App\Models\PickAndDrop\PickAndDrop;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deliveryQuery = Delivery::query();

        $deliveryQuery->where(function ($deliveryQuery) use ($request) {
            $deliveryQuery->where('user_id', $request->user()->id);

            if ($request->filled('status') && !empty($request->query('status'))) {
                $deliveryQuery->where('status', $request->query('status'));
            }
        });

        return inertia('Delivery/Delivery', [
            'deliveries' => $deliveryQuery->with([
                                                'pasuyo.attachments',
                                                'pasuyo.trackings',
                                                'pickAndDrop.trackings'
                                            ])
                                            ->latest()
                                            ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Delivery/Create', [
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
