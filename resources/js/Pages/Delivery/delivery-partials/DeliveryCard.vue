<script setup>

import LocationModal from '@/Pages/User/transaction-partials/pasuyo-tab-partials/LocationModal.vue';
import LocationRouteModal from '@/Pages/User/transaction-partials/pickanddrop-tab-partials/pick-and-drop-details-modal-partials/LocationRouteModal.vue';
import { Tag, Button } from 'primevue';
import UpdateDeliveryModal from './delivery-card-partials/UpdateDeliveryModal.vue';
import TrackingModal from './delivery-card-partials/TrackingModal.vue';

defineProps({
    deliveryList: {
        type: Array,
        default: () => [],
    },
});

const getDeliveryData = (delivery) => {
    if (delivery.type === 'pick_and_drop' && delivery.pick_and_drop) {
        return delivery.pick_and_drop;
    }
    return delivery.pasuyo;
};

const getStatusColor = (status) => {
    const colors = {
        'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        'accepted': 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        'in_progress': 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
        'completed': 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    };
    return colors[status] || colors.pending;
};

</script>

<template>
    <div class="space-y-3">
        <div
            v-for="delivery in deliveryList"
            :key="delivery.id"
            class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-lg transition-all"
        >
            <!-- Header with Status -->
            <div class="flex items-center justify-between p-3 border-b border-zinc-100 dark:border-zinc-700">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                        <i class="ri-map-pin-line text-emerald-600 dark:text-emerald-400 text-sm"></i>
                    </div>
                    <span class="text-xs font-thin text-zinc-900 dark:text-zinc-100">Delivery ID: {{ delivery.id }}</span>
                </div>
                <span :class="['text-xs font-semibold px-2 py-1 rounded-full', getStatusColor(delivery.status)]">
                    {{ delivery?.status }}
                </span>
            </div>

            <template v-if="delivery?.type === 'pasuyo'">
                <!-- Pasuyo Destination -->
                <div class="p-3 border-b border-zinc-100 dark:border-zinc-700">
                    <div class="flex gap-2">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                                <i class="ri-map-pin-2-line text-emerald-600 dark:text-emerald-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">DELIVERY LOCATION</p>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-0.5">{{ getDeliveryData(delivery).full_name }}</p>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">{{ getDeliveryData(delivery).location }}</p>
                            <a :href="`tel:${getDeliveryData(delivery).phone}`" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ getDeliveryData(delivery).phone }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pasuyo Note -->
                <div v-if="getDeliveryData(delivery).note" class="p-3 border-b border-zinc-100 dark:border-zinc-700 bg-blue-50 dark:bg-blue-900/10">
                    <div class="flex gap-2">
                        <i class="ri-sticky-note-line text-blue-600 dark:text-blue-400 text-sm mt-0.5 flex-shrink-0"></i>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">NOTE</p>
                            <p class="text-xs text-zinc-900 dark:text-zinc-100">{{ getDeliveryData(delivery).note }}</p>
                        </div>
                    </div>
                </div>
            </template>

            <template v-if="delivery?.type === 'pick_and_drop'">
                <!-- Pickup Location -->
                <div class="p-3 border-b border-zinc-100 dark:border-zinc-700">
                    <div class="flex gap-2">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <i class="ri-map-pin-2-line text-blue-600 dark:text-blue-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">PICKUP</p>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-0.5">{{ getDeliveryData(delivery).sender_full_name }}</p>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">{{ getDeliveryData(delivery).sender_location }}</p>
                            <a :href="`tel:${getDeliveryData(delivery).sender_phone}`" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ getDeliveryData(delivery).sender_phone }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dropoff Location -->
                <div class="p-3 border-b border-zinc-100 dark:border-zinc-700">
                    <div class="flex gap-2">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                                <i class="ri-map-pin-2-fill text-orange-600 dark:text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1">DROPOFF</p>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-0.5">{{ getDeliveryData(delivery).receiver_full_name }}</p>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">{{ getDeliveryData(delivery).receiver_location }}</p>
                            <a :href="`tel:${getDeliveryData(delivery).receiver_phone}`" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                {{ getDeliveryData(delivery).receiver_phone }}
                            </a>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Item & Payment Info -->
            <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 space-y-2">
                <div class="flex items-start gap-2">
                    <i class="ri-file-text-line text-zinc-400 text-sm mt-0.5 flex-shrink-0"></i>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Item</p>
                        <p class="text-xs text-zinc-900 dark:text-zinc-100" v-if="delivery?.type === 'pick_and_drop'">{{ getDeliveryData(delivery).item_description || 'No description' }}</p>
                        <p class="text-xs text-zinc-900 dark:text-zinc-100" v-if="delivery?.type === 'pasuyo'">{{ getDeliveryData(delivery).content }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-wallet-3-line text-zinc-400 text-sm flex-shrink-0"></i>
                    <div>
                        <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Payment</p>
                        <p class="text-xs text-zinc-900 dark:text-zinc-100">{{ getDeliveryData(delivery).payment_method }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-3 border-t border-zinc-100 dark:border-zinc-700 flex gap-2">
                <LocationRouteModal
                    v-if="delivery?.type === 'pick_and_drop'"
                    :pick-and-drop="delivery?.pick_and_drop"
                />
                <LocationModal
                    v-if="delivery?.type === 'pasuyo'"
                    :pasuyo="delivery?.pasuyo"
                />
                <TrackingModal :delivery="delivery" />
                <UpdateDeliveryModal
                    v-if="route().queryParams.status !== 'completed' && route().queryParams.status !== 'cancelled'"
                    :delivery="delivery"
                />

            </div>
        </div>
    </div>
</template>
