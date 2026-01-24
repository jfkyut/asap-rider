<?php

namespace App\Http\Controllers;

use App\Models\Message\Message;
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
        $delivery = Delivery::create([
            'type' => $request->input('type'),
            'pasuyo_id' => $request->input('pasuyo_id'),
            'pick_and_drop_id' => $request->input('pick_and_drop_id'),
            'status' => 'accepted',
            'user_id' => $request->user()->id,
        ]);

        if ($request->input('type') === 'pasuyo') {
            $pasuyo = Pasuyo::find($request->input('pasuyo_id'));
            $pasuyo->status = 'in_progress';
            $pasuyo->save();

            Message::create([
                'sender_id' => null,
                'body' => 'Your pasuyo id: ' . $pasuyo->id . ' has been accepted for delivery.',
                'preview' => 'Your pasuyo id: ' . $pasuyo->id . ' has been accepted for delivery.',
                'type' => 'system',
                'is_read' => false,
                'user_id' => $pasuyo->user_id,
            ]);

        } elseif ($request->input('type') === 'pick_and_drop') {
            $pickAndDrop = PickAndDrop::find($request->input('pick_and_drop_id'));
            $pickAndDrop->status = 'in_progress';
            $pickAndDrop->save();

            Message::create([
                'sender_id' => null,
                'body' => 'Your pick and drop id: ' . $pickAndDrop->id . ' has been accepted for delivery.',
                'preview' => 'Your pick and drop id: ' . $pickAndDrop->id . ' has been accepted for delivery.',
                'type' => 'system',
                'is_read' => false,
                'user_id' => $pickAndDrop->user_id,
            ]);
        }

        Message::create([
            'sender_id' => null,
            'body' => 'You accepted a delivery id: ' . $delivery->id,
            'preview' => 'You accepted a delivery id: ' . $delivery->id,
            'type' => 'system',
            'is_read' => false,
            'user_id' => $request->user()->id,
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
