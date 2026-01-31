<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Trial Plan',
                'price' => 0.00,
                'description' => 'Access to all features for a limited time',
                'duration' => 3,
            ],
            [
                'name' => 'Monthly Plan',
                'price' => 200.00,
                'description' => 'Access to all features for a month',
                'duration' => 30,
            ],
            [
                'name' => 'Yearly Plan',
                'price' => 1400.00,
                'description' => 'Access to all features for a year',
                'duration' => 365,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan\Plan::create($plan);
        }
    }
}
