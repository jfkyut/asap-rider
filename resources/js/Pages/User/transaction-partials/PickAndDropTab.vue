<script setup>

import { Button, Tag } from 'primevue';
import { useTransactions } from '@/Composables/transactions';
import PickAndDropDetailsModal from './pickanddrop-tab-partials/PickAndDropDetailsModal.vue';
import { ref } from 'vue';

defineProps({
    pickAndDrops: Array
});

const {
    getStatusSeverity,
    formatDate,
    formatTime
} = useTransactions();

const selectedPickAndDropId = ref(null);

</script>

<template>
    <div>
        <!-- Empty State -->
        <div v-if="!pickAndDrops || pickAndDrops.length === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">No pick & drop requests yet</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-500">Create your first pick and drop request to get started.</p>
        </div>

        <!-- Pick & Drop List -->
        <div v-else class="space-y-2">
            <div @click="selectedPickAndDropId = pickAndDrop.id" v-for="pickAndDrop in pickAndDrops" :key="pickAndDrop.id" class="bg-white dark:bg-zinc-900 rounded-lg shadow dark:shadow-lg hover:shadow-md dark:hover:shadow-lg transition-shadow border dark:border-zinc-800 overflow-hidden">
                <!-- Header -->
                <div class="px-3 py-2.5 flex items-start justify-between gap-2">
                    <div class="flex items-start gap-2 flex-1 min-w-0">
                        <Tag :value="pickAndDrop.status.replace('_', ' ')" :severity="getStatusSeverity(pickAndDrop.status)" class="flex-shrink-0 text-xs" />
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-semibold text-zinc-900 dark:text-white truncate">
                                {{ pickAndDrop.sender_full_name }} → {{ pickAndDrop.receiver_full_name }}
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ formatDate(pickAndDrop.created_at) }}</p>
                        </div>
                    </div>
                    <span class="text-sm flex-shrink-0">{{ pickAndDrop.payment_method === 'Cash on Delivery' ? '💵' : '📱' }}</span>
                </div>

                <!-- Details Row -->
                <div class="px-3 py-2 bg-zinc-50 dark:bg-zinc-800/30 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between gap-3 text-xs">
                    <div class="flex-1 min-w-0">
                        <p class="text-zinc-600 dark:text-zinc-400 truncate">From: {{ pickAndDrop.sender_location }}</p>
                    </div>
                    <div class="flex-1 min-w-0 text-right">
                        <p class="text-zinc-600 dark:text-zinc-400 truncate">To: {{ pickAndDrop.receiver_location }}</p>
                    </div>
                    <PickAndDropDetailsModal 
                        :pick-and-drop="pickAndDrop"
                        :show="selectedPickAndDropId === pickAndDrop.id"
                        @close="selectedPickAndDropId = null"
                    />
                </div>
            </div>
        </div>
    </div>
</template>