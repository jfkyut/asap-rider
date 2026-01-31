<?php

namespace App\Http\Controllers;

use App\Models\Plan\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Subscription\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentSubscription = $request->user()->currentSubscription();
        $plan = $currentSubscription ? Plan::find($currentSubscription->plan_id) : null;

        return inertia('Subscription/Subscription', [
            'subscription' => $currentSubscription,
            'plan' => $plan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Plan $plan)
    {
        if ($plan->name === 'Trial Plan') {
            $request->user()->subscriptions()->create([
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration),
            ]);

            return redirect(route('subscription.index'));
        }

        $response = Http::withHeaders([
                            'accept' => 'application/json',
                            'authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY')),
                            'content-type' => 'application/json',
                        ])
                        ->post(
                            'https://api.paymongo.com/v1/checkout_sessions',
                            [
                                'data' => [
                                    'id' => 'cs_CbFCTDfxvMFNjwjVi26Uzhtj',
                                    'type' => 'checkout_session',
                                    'attributes' => [
                                        'merchant' => 'JAM Subscription Service',
                                        'success_url' => route('subscription.store'),
                                        'cancel_url' => route('subscription.index'),
                                        'billing' => [
                                            // 'address' => [
                                            //     'city' => 'Taguig',
                                            //     'country' => 'PH',
                                            //     'line1' => 'address line 1',
                                            //     'line2' => 'address line 2',
                                            //     'postal_code' => '1234',
                                            //     'state' => 'PH-MNL'
                                            // ],
                                            'email' => $request->user()->email,
                                            'name' => $request->user()->name,
                                            'phone' => $request->user()->phone,
                                        ],
                                        'description' => $plan->description,
                                        'line_items' => [
                                            [
                                                'amount' => $plan->price * 100,
                                                'currency' => 'PHP',
                                                'description' => $plan->description,
                                                // 'images' => [
                                                //     'https://images.unsplash.com/photo-1612346903007-b5ac8bb135bb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80'
                                                // ],
                                                'name' => $plan->name,
                                                'quantity' => 1
                                            ],
                                        ],
                                        'livemode' => true,
                                        'payment_intent' => [
                                            'id' => 'pi_aJsHfCD2AmR9V5KBvtkW8XY2',
                                            'type' => 'payment_intent',
                                            'attributes' => [
                                                'currency' => 'PHP',
                                                'description' => $plan->description,
                                                'status' => 'succeeded',
                                                'statement_descriptor' => 'Paymongo Test Account',

                                            ]
                                        ],
                                        'payment_method_types' => ['card', 'gcash',],
                                        'reference_number' => 'm2m39sj43h5lfFSA1sd',
                                        'status' => 'active',
                                    ]
                                ]
                            ]
                        );

        Session::put([
            'selected_plan_id' => $plan->id,
        ]);

        // dd($response->json());

        return inertia('Subscription/Checkout', [
            'redirectUrl' => $response->json()['data']['attributes']['checkout_url']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plan = Plan::find(Session::get('selected_plan_id'));


        $request->user()->subscriptions()->create([
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration),
        ]);

        return redirect(route('subscription.index'));
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
