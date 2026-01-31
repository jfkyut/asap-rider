<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    subscription: Object,
    plan: Object,
});

</script>

<template>
    <Head title="Subscription Management" />
    <AuthenticatedLayout>
        <template #header>
            Subscription Management
        </template>

        <div class="p-4 max-w-7xl mx-auto">
            <h2 class="text-2xl font-semibold mb-8 text-center">Subscription Management</h2>
            <div v-if="subscription">
                <p class="mb-4">You are currently subscribed to the <strong>{{ plan.name }}</strong> plan.</p>
                <p class="mb-4">Subscription valid until: <strong>{{ new Date(subscription.end_date).toLocaleDateString() }}</strong></p>
                <!-- Additional subscription details can go here -->
            </div>
            <div v-else>
                <p class="mb-4">You do not have an active subscription.</p>
                <Link
                    href="/plans"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                >
                    Choose a Plan
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
