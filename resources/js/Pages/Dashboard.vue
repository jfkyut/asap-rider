<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    counts: Object,
});

</script>

<template>
    <Head title="Rider Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="sm:p-6 max-w-7xl mx-auto sm:py-6">
            <!-- Welcome Card with Profile -->
            <div class="border border-emerald-500 dark:border-emerald-800 p-2 rounded-lg flex justify-between items-center mb-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                <div>
                    <div class="text-xs capitalize font-bold text-zinc-900 dark:text-zinc-100">
                        Welcome back, {{ $page.props.auth.user.name }}!
                    </div>
                    <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-0.5">Ready to earn today?</p>
                </div>
                <div>
                    <ApplicationLogo class="w-8" />
                </div>
            </div>

            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-2 gap-1 mb-4">
                <!-- Total Earnings -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/50 rounded-lg p-2.5 border border-green-300 dark:border-green-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-green-700 dark:text-green-400 font-semibold mb-0.5">Total Earnings</p>
                            <p class="text-sm font-bold text-green-900 dark:text-green-100">₱2,450</p>
                            <p class="text-xs text-green-600 dark:text-green-300 mt-0.5">This month</p>
                        </div>
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm">
                            <i class="ri-coins-line"></i>
                        </div>
                    </div>
                </div>

                <!-- Completed Rides -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/50 rounded-lg p-2.5 border border-blue-300 dark:border-blue-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-blue-700 dark:text-blue-400 font-semibold mb-0.5">Completed Rides</p>
                            <p class="text-sm font-bold text-blue-900 dark:text-blue-100">{{ counts.completed }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-300 mt-0.5">Great performance!</p>
                        </div>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">
                            <i class="ri-checkbox-circle-line"></i>
                        </div>
                    </div>
                </div>

                <!-- Rating -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/50 rounded-lg p-2.5 border border-amber-300 dark:border-amber-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-amber-700 dark:text-amber-400 font-semibold mb-0.5">Your Rating</p>
                            <p class="text-sm font-bold text-amber-900 dark:text-amber-100">4.8 <span class="text-xs">★</span></p>
                            <p class="text-xs text-amber-600 dark:text-amber-300 mt-0.5">Based on 45 rides</p>
                        </div>
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white text-sm">
                            <i class="ri-star-line"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Rides -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/50 rounded-lg p-2.5 border border-purple-300 dark:border-purple-700">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-purple-700 dark:text-purple-400 font-semibold mb-0.5">Active Rides</p>
                            <p class="text-sm font-bold text-purple-900 dark:text-purple-100">{{ counts.in_progress }}</p>
                            <p class="text-xs text-purple-600 dark:text-purple-300 mt-0.5">Currently delivering</p>
                        </div>
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm animate-pulse">
                            <i class="ri-riding-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-1">
                    <!-- View Available Jobs -->
                    <div @click="router.get(route('job.index'))" class="group relative overflow-hidden rounded-lg border-2 border-emerald-400 dark:border-emerald-600 bg-gradient-to-br from-emerald-50 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/50 p-3 hover:shadow-lg transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-emerald-200 dark:bg-emerald-700 rounded-full -mr-4 -mt-4 opacity-50 group-hover:opacity-75 transition-opacity"></div>

                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white text-sm mr-1.5">
                                    <i class="ri-file-list-3-line"></i>
                                </div>
                                <span class="font-semibold text-emerald-900 dark:text-emerald-100 text-xs">Available Jobs</span>
                                <span class="ml-auto bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ counts.pending }}</span>
                            </div>

                            <p class="text-zinc-700 dark:text-zinc-300 mb-1.5 text-xs leading-tight">
                                Available delivery requests
                            </p>

                            <div class="flex items-center text-emerald-600 dark:text-emerald-400 font-semibold text-xs hover:translate-x-1 transition-transform">
                                See jobs <i class="ri-arrow-right-s-line ml-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- My Active Deliveries -->
                    <div @click="router.get(route('status.index', { status: 'in_progress' }))" class="group relative overflow-hidden rounded-lg border-2 border-purple-400 dark:border-purple-600 bg-gradient-to-br from-purple-50 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/50 p-3 hover:shadow-lg transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-purple-200 dark:bg-purple-700 rounded-full -mr-4 -mt-4 opacity-50 group-hover:opacity-75 transition-opacity"></div>

                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center text-white text-sm mr-1.5 animate-pulse">
                                    <i class="ri-map-pin-line"></i>
                                </div>
                                <span class="font-semibold text-purple-900 dark:text-purple-100 text-xs">In Progress</span>
                                <span class="ml-auto bg-purple-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ counts.in_progress }}</span>
                            </div>

                            <p class="text-zinc-700 dark:text-zinc-300 mb-1.5 text-xs leading-tight">
                                Track active deliveries
                            </p>

                            <div class="flex items-center text-purple-600 dark:text-purple-400 font-semibold text-xs hover:translate-x-1 transition-transform">
                                Track now <i class="ri-arrow-right-s-line ml-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Rides -->
                    <div @click="router.get(route('status.index', { status: 'completed' }))" class="group relative overflow-hidden rounded-lg border-2 border-blue-400 dark:border-blue-600 bg-gradient-to-br from-blue-50 to-cyan-100 dark:from-blue-900/30 dark:to-cyan-900/50 p-3 hover:shadow-lg transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-blue-200 dark:bg-blue-700 rounded-full -mr-4 -mt-4 opacity-50 group-hover:opacity-75 transition-opacity"></div>

                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm mr-1.5">
                                    <i class="ri-check-double-line"></i>
                                </div>
                                <span class="font-semibold text-blue-900 dark:text-blue-100 text-xs">Completed</span>
                                <span class="ml-auto bg-blue-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold">{{ counts.completed }}</span>
                            </div>

                            <p class="text-zinc-700 dark:text-zinc-300 mb-1.5 text-xs leading-tight">
                                View completed deliveries
                            </p>

                            <div class="flex items-center text-blue-600 dark:text-blue-400 font-semibold text-xs hover:translate-x-1 transition-transform">
                                View history <i class="ri-arrow-right-s-line ml-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings & Payments -->
                    <div class="group relative overflow-hidden rounded-lg border-2 border-green-400 dark:border-green-600 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/50 p-3 hover:shadow-lg transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 w-12 h-12 bg-green-200 dark:bg-green-700 rounded-full -mr-4 -mt-4 opacity-50 group-hover:opacity-75 transition-opacity"></div>

                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white text-sm mr-1.5">
                                    <i class="ri-wallet-line"></i>
                                </div>
                                <span class="font-semibold text-green-900 dark:text-green-100 text-xs">Earnings</span>
                            </div>

                            <p class="text-zinc-700 dark:text-zinc-300 mb-1.5 text-xs leading-tight">
                                Track earnings and payouts
                            </p>

                            <div class="flex items-center text-green-600 dark:text-green-400 font-semibold text-xs hover:translate-x-1 transition-transform">
                                View details <i class="ri-arrow-right-s-line ml-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ride Status Summary -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Ride Overview</h3>
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-3">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mr-2">
                                    <i class="ri-time-line text-yellow-600 dark:text-yellow-400 text-xs"></i>
                                </div>
                                <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100">Pending Acceptance</span>
                            </div>
                            <span class="text-sm font-bold text-yellow-600 dark:text-yellow-400">{{ counts.pending }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mr-2">
                                    <i class="ri-check-line text-blue-600 dark:text-blue-400 text-xs"></i>
                                </div>
                                <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100">Ready to Pickup</span>
                            </div>
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ counts.accepted }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mr-2">
                                    <i class="ri-map-pin-line text-purple-600 dark:text-purple-400 text-xs animate-pulse"></i>
                                </div>
                                <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100">Currently Delivering</span>
                            </div>
                            <span class="text-sm font-bold text-purple-600 dark:text-purple-400">{{ counts.in_progress }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mr-2">
                                    <i class="ri-check-double-line text-green-600 dark:text-green-400 text-xs"></i>
                                </div>
                                <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100">Completed Today</span>
                            </div>
                            <span class="text-sm font-bold text-green-600 dark:text-green-400">{{ counts.completed }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
