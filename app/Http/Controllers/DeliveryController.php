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
                $status = $request->query('status');
                if ($status === 'active') {
                    $deliveryQuery->where('status', '!=', 'completed');
                } else {
                    $deliveryQuery->where('status', $status);
                }
            }
        });

        return inertia('Delivery/Delivery', [
            'deliveries' => $deliveryQuery->with([
                                                'pasuyo.attachments',
                                                'pasuyo',
                                                'pickAndDrop',
                                                'trackings',
                                            ])
                                            ->latest()
                                            ->paginate(100)
                                            ->through(function ($delivery) {
                                                return [
                                                    ...$delivery->toArray(),
                                                    'trackings' => $delivery->trackings->map(function ($tracking) {
                                                        return [
                                                            ...$tracking->toArray(),
                                                            'created_at' => $tracking->created_at->format('M d, Y H:i'),
                                                            'updated_at' => $tracking->updated_at->format('M d, Y H:i'),
                                                        ];
                                                    })->toArray(),
                                                ];
                                            }),
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
    public function update(Request $request, Delivery $delivery)
    {
        $delivery->update([
            'status' => $request->input('status'),
        ]);

        Message::create([
            'sender_id' => null,
            'body' => 'You updated delivery id: ' . $delivery->id . ' to status: ' . $delivery->status,
            'preview' => 'You updated delivery id: ' . $delivery->id . ' to status: ' . $delivery->status,
            'type' => 'system',
            'is_read' => false,
            'user_id' => $request->user()->id,
        ]);

        $delivery->trackings()->create([
            'status_update' => $delivery->status,
        ]);

        if ($delivery->type === 'pasuyo') {
            $pasuyo = $delivery->pasuyo;
            $pasuyo->status = $delivery->status;
            $pasuyo->save();

            Message::create([
                'sender_id' => null,
                'body' => 'Your pasuyo id: ' . $pasuyo->id . ' delivery status has been updated to: ' . $pasuyo->status,
                'preview' => 'Your pasuyo id: ' . $pasuyo->id . ' delivery status has been updated to: ' . $pasuyo->status,
                'type' => 'system',
                'is_read' => false,
                'user_id' => $pasuyo->user_id,
            ]);

        } elseif ($delivery->type === 'pick_and_drop') {
            $pickAndDrop = $delivery->pickAndDrop;
            $pickAndDrop->status = $delivery->status;
            $pickAndDrop->save();

            Message::create([
                'sender_id' => null,
                'body' => 'Your pick and drop id: ' . $pickAndDrop->id . ' delivery status has been updated to: ' . $pickAndDrop->status,
                'preview' => 'Your pick and drop id: ' . $pickAndDrop->id . ' delivery status has been updated to: ' . $pickAndDrop->status,
                'type' => 'system',
                'is_read' => false,
                'user_id' => $pickAndDrop->user_id,
            ]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
