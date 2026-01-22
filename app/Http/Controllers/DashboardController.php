<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasuyo\Pasuyo;
use App\Models\PickAndDrop\PickAndDrop;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendingCount = (Pasuyo::where('user_id', auth()->id())
                              ->where('status', 'pending')
                              ->count()) +
                        (PickAndDrop::where('user_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->count());

        $acceptedCount = (Pasuyo::where('user_id', auth()->id())
                               ->where('status', 'accepted')
                               ->count()) +
                         (PickAndDrop::where('user_id', auth()->id())
                                     ->where('status', 'accepted')
                                     ->count());

        $inProgressCount = (Pasuyo::where('user_id', auth()->id())
                                 ->where('status', 'in_progress')
                                 ->count()) +
                           (PickAndDrop::where('user_id', auth()->id())
                                       ->where('status', 'in_progress')
                                       ->count());

        $completedCount = (Pasuyo::where('user_id', auth()->id())
                                 ->where('status', 'completed')
                                 ->count()) +
                          (PickAndDrop::where('user_id', auth()->id())
                                      ->where('status', 'completed')
                                      ->count());

        return inertia('Dashboard', [
            'counts' => [
                'pending' => $pendingCount,
                'accepted' => $acceptedCount,
                'in_progress' => $inProgressCount,
                'completed' => $completedCount,
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
