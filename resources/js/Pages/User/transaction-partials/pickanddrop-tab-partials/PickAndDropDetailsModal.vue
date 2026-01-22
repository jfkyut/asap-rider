<script setup>

import Modal from '@/Components/Modal.vue';
import Container from '@/Components/Container.vue';
import { useTransactions } from '@/Composables/transactions';
import { Tag, Button } from 'primevue';
import { ref } from 'vue';
import LocationRouteModal from './pick-and-drop-details-modal-partials/LocationRouteModal.vue';
import ReceiverLocationModal from './pick-and-drop-details-modal-partials/ReceiverLocationModal.vue';

defineProps({
    pickAndDrop: Object,
    show: {
        type: Boolean,
        default: false,
    }
})

const { getStatusSeverity, formatDate } = useTransactions();


</script>

<template>
    <button class="flex-shrink-0 text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300">
        →
    </button>

    <Modal
        :show="show"
        @close="$emit('close')"
    >
        <Container>
            <template #header>
                <div class="flex items-center justify-between">
                    <header>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Pick & Drop Details</h3>
                        <div class="text-xs mt-2">
                            <Tag :value="pickAndDrop.status.replace('_', ' ')" :severity="getStatusSeverity(pickAndDrop.status)" />
                        </div>
                    </header>
                    <div class="flex gap-2 items-center">
                        <Button severity="secondary" variant="outlined" @click="$emit('close')">
                            <span class="text-xs">Close</span>
                        </Button>
                    </div>
                </div>
            </template>

            <template #body>
                <div class="space-y-4">
                    <!-- Pickup Section -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border-l-4 border-blue-500 space-y-3">
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200">📍 Pickup Details</h4>
                        <div class="space-y-2.5">
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Full Name</p>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.sender_full_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Phone</p>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.sender_phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Location</p>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.sender_location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item Section -->
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-4 border-l-4 border-amber-500 space-y-3">
                        <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-200">📦 Item Description</h4>
                        <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.item_description || '—' }}</p>
                    </div>

                    <!-- Delivery Section -->
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 border-l-4 border-purple-500 space-y-3">
                        <h4 class="text-sm font-semibold text-purple-900 dark:text-purple-200">🏁 Delivery Details</h4>
                        <div class="space-y-2.5">
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Full Name</p>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.receiver_full_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Phone</p>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.receiver_phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Location</p>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.receiver_location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Coordinates Section -->
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 border-l-4 border-indigo-500 space-y-3">
                        <h4 class="text-sm font-semibold text-indigo-900 dark:text-indigo-200">🗺️ Coordinates</h4>
                        <div class="space-y-2.5">
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Pickup Coordinates</p>
                                <p class="text-sm text-zinc-900 dark:text-white font-mono">{{ pickAndDrop.sender_location_coordinates || '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Delivery Coordinates</p>
                                <p class="text-sm text-zinc-900 dark:text-white font-mono">{{ pickAndDrop.receiver_location_coordinates || '—' }}</p>
                            </div>
                        </div>
                        <LocationRouteModal
                            :pick-and-drop="pickAndDrop"
                        />
                    </div>

                    <!-- Payment Section -->
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border-l-4 border-green-500">
                        <h4 class="text-sm font-semibold text-green-900 dark:text-green-200 mb-2">💳 Payment Method</h4>
                        <p class="text-sm text-zinc-900 dark:text-white">{{ pickAndDrop.payment_method || '—' }}</p>
                    </div>

                    <!-- Date Section -->
                    <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-4">
                        <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wide mb-1">Created</p>
                        <p class="text-sm text-zinc-900 dark:text-white">{{ formatDate(pickAndDrop.created_at) }}</p>
                    </div>
                </div>
            </template>
        </Container>
    </Modal>
</template>
