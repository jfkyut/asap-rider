<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button, Tag } from 'primevue';
import { Head } from '@inertiajs/vue3';
import { computed, toRefs } from 'vue';
import DeliveryCard from './delivery-partials/DeliveryCard.vue';

const props = defineProps({
    deliveries: Object
});

const { deliveries } = toRefs(props);

const deliveryList = computed(() => {
    return deliveries.value?.data || [];
});

</script>

<template>
    <AuthenticatedLayout>
        <Head title="My Deliveries" />

        <template #header>
            <h2>My Deliveries</h2>
        </template>

        <div class="sm:p-6 max-w-7xl mx-auto px-2 py-2 sm:py-6">
            <!-- Empty State -->
            <div v-if="deliveryList.length === 0" class="text-center py-12">
                <div class="w-16 h-16 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-inbox-line text-zinc-400 text-2xl"></i>
                </div>
                <p class="text-zinc-600 dark:text-zinc-400">No deliveries yet</p>
            </div>

            <!-- Delivery Cards -->
            <DeliveryCard :deliveryList="deliveryList" />
        </div>
    </AuthenticatedLayout>
</template>
