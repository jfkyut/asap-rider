<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasuyo\Pasuyo;
use App\Models\PickAndDrop\PickAndDrop;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pasuyoQuery = Pasuyo::query();
        $pickAndDropQuery = PickAndDrop::query();

        $pasuyoQuery->where(function ($pasuyoQuery) use ($request) {
            $pasuyoQuery->where('user_id', $request->user()->id);

            if ($request->filled('status') && !empty($request->query('status'))) {
                $pasuyoQuery->where('status', $request->query('status'));
            }
        });

        $pickAndDropQuery->where(function ($pickAndDropQuery) use ($request) {
            $pickAndDropQuery->where('user_id', $request->user()->id);

            if ($request->filled('status') && !empty($request->query('status'))) {
                $pickAndDropQuery->where('status', $request->query('status'));
            }
        });

        $payusos = $pasuyoQuery->with(
                                    'attachments', 
                                    'trackings'
                                )
                                ->latest()
                                ->get();
        $pickAndDrops = $pickAndDropQuery->with('trackings')
                                        ->latest()
                                        ->get();

        

        return inertia('Status/Status', [
            'transactions' => [
                'pasuyos' => $payusos,
                'pickAndDrops' => $pickAndDrops
            ],
            'status' => $request->query('status', null)
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
