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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Home
        </template>

        <div class="border border-teal-500 dark:border-teal-800 p-2 rounded flex justify-between items-center mb-6 bg-teal-50 dark:bg-teal-900/20">
            <div class="text-sm capitalize font-bold">
                Hello, {{ $page.props.auth.user.name }}! 
            </div>
            <div>
                <ApplicationLogo class="w-10" />
            </div>
        </div>

        <div class="sm:p-6 max-w-7xl mx-auto px-2 py-2 sm:py-6">
            <!-- Request Status Overview -->
            <div class="mb-6">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 mb-3">Transactions</h3>
                <div class="flex gap-2 overflow-x-auto pb-2 -mx-2 px-2 sm:mx-0 sm:px-0">
                    <!-- Pending -->
                    <div @click="router.get(route('status.index', { status: 'pending' }))" class="flex-shrink-0 w-24 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/40 dark:to-yellow-900/20 rounded-lg p-3 border-l-4 border-yellow-500">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-xs mb-1 flex-shrink-0">
                                <i class="ri-time-line"></i>
                            </div>
                            <p class="text-xs font-semibold text-yellow-700 dark:text-yellow-400 mb-1">Pending</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ counts.pending }}</p>
                        </div>
                    </div>

                    <!-- Accepted -->
                    <div @click="router.get(route('status.index', { status: 'accepted' }))" class="flex-shrink-0 w-24 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/40 dark:to-blue-900/20 rounded-lg p-3 border-l-4 border-blue-500">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs mb-1 flex-shrink-0">
                                <i class="ri-check-line"></i>
                            </div>
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-400 mb-1">Accepted</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ counts.accepted }}</p>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div @click="router.get(route('status.index', { status: 'in_progress' }))" class="flex-shrink-0 w-24 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/40 dark:to-purple-900/20 rounded-lg p-3 border-l-4 border-purple-500">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs mb-1 flex-shrink-0 animate-pulse">
                                <i class="ri-map-pin-user-line"></i>
                            </div>
                            <p class="text-xs font-semibold text-purple-700 dark:text-purple-400 mb-1">In Progress</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ counts.in_progress }}</p>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div @click="router.get(route('status.index', { status: 'completed' }))" class="flex-shrink-0 w-24 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/40 dark:to-green-900/20 rounded-lg p-3 border-l-4 border-green-500">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs mb-1 flex-shrink-0">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                            <p class="text-xs font-semibold text-green-700 dark:text-green-400 mb-1">Completed</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ counts.completed }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100 mb-3">
                    What You Can Do
                </h3>
                
                <!-- Core Systems Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- System 1 -->
                    <div @click="router.get(route('pasuyo.create'))" class="group relative overflow-hidden rounded-lg border-2 border-blue-400 dark:border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/50 p-4 hover:shadow-lg transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-blue-200 dark:bg-blue-700 rounded-full -mr-6 -mt-6 opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm mr-2 flex-shrink-0">
                                    <i class="ri-run-line"></i>
                                </div>
                                <h4 class="text-sm font-bold text-zinc-900 dark:text-white">
                                    Pasuyo
                                </h4>
                            </div>
                            
                            <p class="text-zinc-700 dark:text-zinc-300 mb-2 text-xs leading-tight">
                                Request errands from a rider.
                            </p>
                            
                            <div class="flex items-center text-blue-600 dark:text-blue-400 font-semibold text-xs hover:translate-x-1 transition-transform">
                                Request
                                <span class="ml-1">→</span>
                            </div>
                        </div>
                    </div>

                    <!-- System 2 -->
                    <div @click="router.get(route('pick-and-drop.create'))" class="group relative overflow-hidden rounded-lg border-2 border-purple-400 dark:border-purple-600 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-900/50 p-4 hover:shadow-lg transition-all duration-300 cursor-pointer">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-purple-200 dark:bg-purple-700 rounded-full -mr-6 -mt-6 opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center text-white text-sm mr-2 flex-shrink-0">
                                    <i class="ri-route-line"></i>
                                </div>
                                <h4 class="text-sm font-bold text-zinc-900 dark:text-white">
                                    Pick & Drop
                                </h4>
                            </div>
                            
                            <p class="text-zinc-700 dark:text-zinc-300 mb-2 text-xs leading-tight">
                                Same-day delivery service.
                            </p>
                            
                            <div class="flex items-center text-purple-600 dark:text-purple-400 font-semibold text-xs hover:translate-x-1 transition-transform">
                                Request
                                <span class="ml-1">→</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
