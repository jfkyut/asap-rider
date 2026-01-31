<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

defineProps({
    plans: Array,
});

const handleSubscribe = (planId) => {
    router.get(route('subscription.create', { plan: planId }));
};
</script>

<template>
    <Head title="Choose Your Plan" />

    <div class="min-h-screen bg-gradient-to-b from-slate-50 to-white px-4 py-6">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Choose Your Plan</h2>
            <p class="text-gray-600 text-sm">Select the plan that works best for you</p>
        </div>

        <!-- Plans Container -->
        <div class="space-y-4 max-w-md mx-auto">
            <div
                v-for="plan in plans"
                :key="plan.id"
                class="relative bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden"
                :class="plan.name === 'Monthly Plan' ? 'ring-2 ring-blue-500' : ''"
            >
                <!-- Recommended Badge -->
                <div v-if="plan.name === 'Monthly Plan'" class="absolute top-0 right-0 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                    Recommended
                </div>

                <!-- Free Badge -->
                <div v-if="plan.price === '0.00'" class="absolute top-0 right-0 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                    FREE
                </div>

                <!-- Plan Content -->
                <div class="p-5">
                    <!-- Plan Name -->
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ plan.name }}</h3>

                    <!-- Price -->
                    <div class="mb-4">
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl font-bold text-gray-900">₱{{ parseFloat(plan.price).toLocaleString('en-PH', { minimumFractionDigits: 2 }) }}</span>
                            <span v-if="plan.price !== '0.00'" class="text-gray-600 text-sm">/month</span>
                        </div>
                        <p v-if="plan.duration === 365" class="text-green-600 text-xs font-semibold mt-1">Best Value - Save ₱600/year</p>
                    </div>

                    <!-- Duration -->
                    <div class="mb-4 inline-flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">{{ plan.duration }} days</span>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">{{ plan.description }}</p>

                    <!-- Subscribe Button -->
                    <button
                        :disabled="plan.name === 'Trial Plan' && $page.props.auth.consumed_trial_plan"
                        @click="handleSubscribe(plan.id)"
                        :class="{
                            'bg-gradient-to-r from-blue-500 to-blue-600 text-white': plan.name === 'Monthly Plan' && !(plan.name === 'Trial Plan' && $page.props.auth.consumed_trial_plan),
                            'bg-gray-100 text-gray-900 hover:bg-gray-200': plan.name !== 'Monthly Plan' && !(plan.name === 'Trial Plan' && $page.props.auth.consumed_trial_plan),
                            'bg-gray-200 text-gray-400 cursor-not-allowed': plan.name === 'Trial Plan' && $page.props.auth.consumed_trial_plan
                        }"
                        class="w-full py-3 rounded-lg font-semibold text-sm transition-all duration-300 active:scale-95"
                    >
                        <span v-if="plan.name === 'Trial Plan' && $page.props.auth.consumed_trial_plan">Trial Already Used</span>
                        <span v-else>{{ plan.price === '0.00' ? 'Start Free Trial' : 'Subscribe Now' }}</span>
                    </button>

                    <!-- Features List -->
                    <div class="mt-5 pt-5 border-t border-gray-200 space-y-2">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Full access to all features</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Priority support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <!-- <div class="mt-8 text-center text-xs text-gray-500 max-w-md mx-auto">
            <p>You can change or cancel your subscription anytime. No hidden fees.</p>
        </div> -->
    </div>
</template>
